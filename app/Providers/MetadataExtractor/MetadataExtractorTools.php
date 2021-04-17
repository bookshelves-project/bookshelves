<?php

namespace App\Providers\MetadataExtractor;

use File;
use Storage;
use ZipArchive;
use App\Utils\Tools;
use Illuminate\Support\Str;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class MetadataExtractorTools
{
    public static function parseXmlFile(string $file_path)
    {
        $file_path = storage_path("app/public/$file_path");

        $zip = new ZipArchive();
        $zip->open($file_path);
        $xml_string = '';
        $coverFile = '';
        $cover_extension = '';
        $options_covers = [];
        // echo epub filename
        // dump(pathinfo($file_path)['basename']);
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            if (strpos($stat['name'], '.opf')) {
                $xml_string = $zip->getFromName($stat['name']);
                Storage::disk('public')->put(pathinfo($file_path)['basename'].'.opf', $xml_string);
            }
            if (preg_match('/cover/', $stat['name'])) {
                if (array_key_exists('extension', pathinfo($stat['name']))) {
                    $cover_extension = pathinfo($stat['name'])['extension'];
                    if (preg_match('/cover/', pathinfo($stat['name'])['basename']) && preg_match('/jpg|jpeg|png|webp/', $cover_extension)) {
                        array_push($options_covers, $zip->getFromName($stat['name']));
                    }
                }
            }
        }

        $coverFile = array_key_exists(0, $options_covers) ? $options_covers[0] : null;

        $package = simplexml_load_string($xml_string);

        // Transform XML to Array
        $xml = self::XMLtoArray($xml_string);
        $xml = $xml['PACKAGE'];
        $cover = null;
        $manifest = $xml['MANIFEST']['ITEM'];
        foreach ($manifest as $key => $value) {
            if ('cover' === $value['ID']) {
                $cover = $value;
            }
        }
        unset($xml['MANIFEST']);
        unset($xml['SPINE']);
        $xml['COVER'] = $cover;
        $title = pathinfo($file_path)['basename'];
        try {
            // dump($xml);
            Storage::disk('public')->put("$title-custom.md", json_encode($xml));
        } catch (\Throwable $th) {
            dump($th);
        }

        $packageMetadata = null;
        try {
            $packageMetadata = $package->metadata->children('dc', true);
        } catch (\Throwable $th) {
            // self::generateError('metadata');
        }
        // Get identifiers with keys
        $xml_string_array = explode(PHP_EOL, $xml_string);
        $identifiers_raw = [];
        foreach ($xml_string_array as $key => $value) {
            $xml_value = trim($value);
            if (str_contains($xml_value, 'dc:identifier')) {
                $xml_value = str_replace('</dc:identifier>', '', $xml_value);
                $xml_value = explode('>', $xml_value);
                $identifier_raw = $xml_value[1];
                $identifier_raw_key = explode('opf:scheme="', $xml_value[0]);
                $identifier_raw_key = strtolower(trim(end($identifier_raw_key)));
                $identifier_raw_key = rtrim($identifier_raw_key, '"');
                if ('uuid' !== $identifier_raw_key && 'calibre' !== $identifier_raw_key) {
                    $identifiers_raw[$identifier_raw_key] = $identifier_raw;
                }
            }
        }

        $serie = null;
        $volume = null;
        try {
            // Parse all tags 'meta' into 'package' => 'metadata'
            foreach ($package->metadata as $key => $value) {
                foreach ($value->meta as $a => $b) {
                    // get serie
                    if (preg_match('/calibre:series$/', $b->attributes()->__toString())) {
                        foreach ($b->attributes() as $k => $v) {
                            if (! preg_match('/series$/', $v->__toString())) {
                                $serie = $v->__toString();
                            }
                        }
                    }
                    // get serie number
                    if (preg_match('/series_index$/', $b->attributes()->__toString())) {
                        foreach ($b->attributes() as $k => $v) {
                            if (! preg_match('/calibre:series_index$/', $v->__toString())) {
                                $volume = $v->__toString();
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        $metadata_from_xml = [];
        try {
            foreach ($packageMetadata as $k => $v) {
                $metadata_from_xml[$k][] = $v->__toString();
            }
        } catch (\Throwable $th) {
            // self::generateError('XML file invalid');
        }

        $metadata_from_raw = [
            'title'        => [],
            'creator'      => [],
            'contributor'  => [],
            'description'  => [],
            'date'         => [],
            'identifier'   => [],
            'publisher'    => [],
            'subject'      => [],
            'language'     => [],
            'rights'       => [],
            'serie'        => [],
            'volume'       => [],
        ];

        foreach ($metadata_from_xml as $key => $value) {
            if (array_key_exists($key, $metadata_from_raw)) {
                for ($i = 0; $i < sizeof($value); $i++) {
                    $el = $value[$i];
                    array_push($metadata_from_raw[$key], $el);
                }
            }
        }

        $metadata = [];
        foreach ($metadata_from_raw as $key => $meta) {
            if (sizeof($meta) <= 1) {
                $metadata[$key] = reset($meta);
            } else {
                $metadata[$key] = $meta;
            }
        }
        $metadata['identifier'] = $identifiers_raw;
        $metadata['serie'] = $serie ? $serie : null;
        $metadata['volume'] = $volume ? $volume : null;
        // $metadata['cover'] = $coverFile ? $coverFile : null;
        $metadata['cover_extension'] = $cover_extension ? $cover_extension : null;

        return [
            'metadata'             => $metadata,
            'coverFile'            => $coverFile,
        ];
    }

    /**
     * Get all EPUB files from storage/books-raw
     * Return false if books-raw not exist.
     *
     * @return false|array
     */
    public static function getAllEpubFiles(int $limit = null): array | false
    {
        try {
            // Get all files in books-raw/
            $files = Storage::disk('public')->allFiles('books-raw');
        } catch (\Throwable $th) {
            dump('storage/books-raw not found');

            return false;
        }

        // Get EPUB files form books-raw/ and create new $epubsFiles[]
        $epubsFiles = [];
        foreach ($files as $key => $value) {
            if (array_key_exists('extension', pathinfo($value)) && 'epub' === pathinfo($value)['extension']) {
                array_push($epubsFiles, $value);
            }
        }

        if ($limit) {
            return array_slice($epubsFiles, 0, $limit);
        }

        return $epubsFiles;
    }

    public static function error(string $type, string $file_path)
    {
        $book = pathinfo($file_path)['filename'];
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()->setStyle('fire', $outputStyle);
        $output->writeln("<fire>Error about $type:</> $book");
    }

    public static function getSortString(string $title)
    {
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
            $title_sort = preg_replace('/^'.preg_quote($value, '/').'/i', '', $title_sort);
        }
        // $title_sort = str_replace($articles, '', $title_sort);
        $title_sort = Tools::cleanString($title_sort);

        return utf8_encode($title_sort);
    }

    public static function cleanText(string $text, string $type = 'html', int $limit = null): string
    {
        $isUTF8 = mb_check_encoding($text, 'UTF-8');
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

        return $text;
    }

    /**
     * Convert XML to an Array.
     *
     * @param string $XML
     *
     * @return array
     */
    public static function XMLtoArray($XML)
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
                $php_stmt .= '[$level['.$start_level.']]';
                if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level]) {
                    $php_stmt .= '['.($multi_key[$level[$start_level]][$start_level] - 1).']';
                }
                $start_level++;
            }
            $add = '';
            if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ('open' == $x_type || 'complete' == $x_type)) {
                if (! isset($multi_key2[$x_tag][$x_level])) {
                    $multi_key2[$x_tag][$x_level] = 0;
                }
                $multi_key2[$x_tag][$x_level]++;

                $add = '['.$multi_key2[$x_tag][$x_level].']';
            }
            if (isset($xml_elem['value']) && '' != trim($xml_elem['value']) && ! array_key_exists('attributes', $xml_elem)) {
                if ('open' == $x_type) {
                    $php_stmt_main = $php_stmt.'[$x_type]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                } else {
                    $php_stmt_main = $php_stmt.'[$x_tag]'.$add.' = $xml_elem[\'value\'];';
                }
                eval($php_stmt_main);
            }
            if (array_key_exists('attributes', $xml_elem)) {
                if (isset($xml_elem['value'])) {
                    $php_stmt_main = $php_stmt.'[$x_tag]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                    eval($php_stmt_main);
                }
                foreach ($xml_elem['attributes'] as $key=>$value) {
                    $php_stmt_att = $php_stmt.'[$x_tag]'.$add.'[$key] = $value;';
                    eval($php_stmt_att);
                }
            }
        }

        return $xml_array;
    }
}
