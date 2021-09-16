<?php

namespace App\Providers\EbookParserEngine;

use Throwable;
use Transliterator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class EbookParserEngineTools
{
    /**
     * Try to get sort title
     */
    public static function getSortString(string|null $title): string|false
    {
        if ($title) {
            $title_sort = $title;
            $articles = [
                'the ',
                'les ',
                "l'",
                'le ',
                'la ',
                // 'a ',
                "d'un",
                "d'",
                'une ',
            ];
            foreach ($articles as $key => $value) {
                $title_sort = preg_replace('/^' . preg_quote($value, '/') . '/i', '', $title_sort);
            }
            $transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);
            $title_sort = $transliterator->transliterate($title_sort);
            $title_sort = strtolower($title_sort);

            return utf8_encode($title_sort);
        }
        return false;
    }

    /**
     * Generate full title sort.
     */
    public static function sortTitleWithSerie(string|null $title, int|null $volume, string|null $serie_title): string
    {
        $serie = null;
        if ($serie_title) {
            $volume = strlen($volume) < 2 ? '0' . $volume : $volume;
            $serie = $serie_title . ' ' . $volume;
            $serie = Str::slug(self::getSortString($serie)) . '_';
        }
        $title = Str::slug(self::getSortString($title));

        return "$serie$title";
    }


    /**
     * Clean HTML input
     */
    public static function cleanText(string|null $text, string $type = 'html', int $limit = null): string|null
    {
        if ($text) {
            try {
                $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);
    
                if ('html' === $type) {
                    $text = filter_var($text, FILTER_SANITIZE_STRING);
                } elseif ('markdown' === $type) {
                    $text = Str::markdown($text);
                }
    
                $text = preg_replace('#<a.*?>.*?</a>#i', '', $text);
                $text = preg_replace('#<img.*?>.*?/>#i', '', $text);
                $text = strip_tags($text, '<br>');
                $text = Str::markdown($text);
    
                if ($limit && strlen($text) > $limit) {
                    $text = substr($text, 0, $limit);
                }
            } catch (\Throwable $th) {
                // TODO Log
                $text = '';
            }
        }

        return $text;
    }

    /**
     * Print in console
     */
    public static function console(string $method, Throwable $throwable)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()->setStyle('fire', $outputStyle);
        
        $output->writeln("<fire>Error about $method:</>");
        $output->writeln($throwable->getMessage());
        $output->writeln($throwable->getFile());
        $output->writeln($throwable->getLine());
    }

    /**
     * Convert XML to an Array.
     */
    public static function XMLtoArray(string $XML): array
    {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $XML, $vals);
        xml_parser_free($xml_parser);
        // wyznaczamy tablice z powtarzajacymi sie tagami na tym samym poziomie
        $_tmp = '';
        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if (1 != $x_level && 'close' == $x_type) {
                if (isset($multi_key[$x_tag][$x_level])) {
                    $multi_key[$x_tag][$x_level] = 1;
                } else {
                    $multi_key[$x_tag][$x_level] = 0;
                }
            }
            if (1 != $x_level && 'complete' == $x_type) {
                if ($_tmp == $x_tag) {
                    $multi_key[$x_tag][$x_level] = 1;
                }
                $_tmp = $x_tag;
            }
        }
        // jedziemy po tablicy
        $xml_array = [];
        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if ('open' == $x_type) {
                $level[$x_level] = $x_tag;
            }
            $start_level = 1;
            $php_stmt = '$xml_array';
            if ('close' == $x_type && 1 != $x_level) {
                $multi_key[$x_tag][$x_level]++;
            }
            while ($start_level < $x_level) {
                $php_stmt .= '[$level[' . $start_level . ']]';
                if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level]) {
                    $php_stmt .= '[' . ($multi_key[$level[$start_level]][$start_level] - 1) . ']';
                }
                $start_level++;
            }
            $add = '';
            if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ('open' == $x_type || 'complete' == $x_type)) {
                if (! isset($multi_key2[$x_tag][$x_level])) {
                    $multi_key2[$x_tag][$x_level] = 0;
                }
                $multi_key2[$x_tag][$x_level]++;

                $add = '[' . $multi_key2[$x_tag][$x_level] . ']';
            }
            if (isset($xml_elem['value']) && '' != trim($xml_elem['value']) && ! array_key_exists('attributes', $xml_elem)) {
                if ('open' == $x_type) {
                    $php_stmt_main = $php_stmt . '[$x_type]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
                } else {
                    $php_stmt_main = $php_stmt . '[$x_tag]' . $add . ' = $xml_elem[\'value\'];';
                }
                eval($php_stmt_main);
            }
            if (array_key_exists('attributes', $xml_elem)) {
                if (isset($xml_elem['value'])) {
                    $php_stmt_main = $php_stmt . '[$x_tag]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
                    eval($php_stmt_main);
                }
                foreach ($xml_elem['attributes'] as $key => $value) {
                    $php_stmt_att = $php_stmt . '[$x_tag]' . $add . '[$key] = $value;';
                    eval($php_stmt_att);
                }
            }
        }

        return $xml_array;
    }
}
