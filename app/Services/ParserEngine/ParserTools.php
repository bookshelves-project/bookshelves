<?php

namespace App\Services\ParserEngine;

use Illuminate\Support\Str;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Throwable;
use Transliterator;

class ParserTools
{
    /**
     * Try to get sort title.
     */
    public static function getSortString(string|null $title): string|false
    {
        if ($title) {
            $slug_sort = $title;
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
                $slug_sort = preg_replace('/^'.preg_quote($value, '/').'/i', '', $slug_sort);
            }
            $transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);
            $slug_sort = $transliterator->transliterate($slug_sort);
            $slug_sort = strtolower($slug_sort);

            return Str::slug(utf8_encode($slug_sort));
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
            // @phpstan-ignore-next-line
            $volume = strlen($volume) < 2 ? '0'.$volume : $volume;
            $serie = $serie_title.' '.$volume;
            $serie = Str::slug(self::getSortString($serie)).'_';
        }
        $title = Str::slug(self::getSortString($title));

        return "{$serie}{$title}";
    }

    /**
     * Remove HTML from string.
     */
    public static function htmlToText(?string $html, ?string $allow = '<br>'): string
    {
        return trim(strip_tags($html, $allow));
    }

    /**
     * Clean HTML input.
     */
    public static function cleanText(string|null $text, string $type = 'html', int $limit = null): string|null
    {
        if ($text) {
            try {
                $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);

                if ('html' === $type) {
                    $text = filter_var($text, FILTER_UNSAFE_RAW);
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
     * Print in console.
     */
    public static function console(string $method, Throwable $throwable)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()->setStyle('fire', $outputStyle);

        $output->writeln("<fire>Error about {$method}:</>");
        $output->writeln($throwable->getMessage());
        $output->writeln($throwable->getFile());
    }
}
