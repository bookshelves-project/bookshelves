<?php

namespace App\Providers\EpubParser;

use Storage;
use ZipArchive;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class EpubParserTools
{
    public static function parseXmlFile(string $file_path)
    {
        $file_path = storage_path("app/public/$file_path");

        $zip = new ZipArchive();
        $zip->open($file_path);
        $xml_string = '';
        $coverFile = '';
        $cover_extension = '';
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            if (strpos($stat['name'], '.opf')) {
                $xml_string = $zip->getFromName($stat['name']);
            }
            if (preg_match('/cover/', $stat['name'])) {
                if (array_key_exists('extension', pathinfo($stat['name']))) {
                    $cover_extension = pathinfo($stat['name'])['extension'];
                    if (preg_match('/jpg|jpeg|PNG|WEBP/', $cover_extension)) {
                        $coverFile = $stat['name'];
                        $coverFile = $zip->getFromName($stat['name']);
                    }
                }
            }
        }

        $package = simplexml_load_string($xml_string);
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
        $serie_number = null;
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
                                $serie_number = $v->__toString();
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
            'serie_number' => [],
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
        $metadata['serie_number'] = $serie_number ? $serie_number : null;
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
    public static function getAllEpubFiles()
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
            "d'",
            'une ',
        ];
        foreach ($articles as $key => $value) {
            $title_sort = preg_replace('/^'.preg_quote($value, '/').'/i', '', $title_sort);
        }
        // $title_sort = str_replace($articles, '', $title_sort);
        $title_sort = stripAccents($title_sort);

        return utf8_encode($title_sort);
    }
}
