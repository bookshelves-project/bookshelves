<?php

namespace App\Utils;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BookshelvesTools
{
    /**
     * Chunk a collection by first character.
     */
    public static function chunkByAlpha(Collection $collection, string $attribute)
    {
        return $collection->mapToGroups(function ($item, $key) use ($attribute) {
            return self::isAlpha($item->{$attribute}[0]) ? [strtoupper($item->{$attribute}[0]) => $item] : ['#' => $item];
        })->sortKeys();
    }

    /**
     * Check if character is alpha.
     *
     * @param  mixed  $toCheck
     */
    public static function isAlpha($toCheck)
    {
        return preg_match('/^[a-zA-Z]+$/', $toCheck);
    }

    /**
     * Convert bytes to human readable filesize.
     */
    public static function humanFilesize(string|int $bytes, ?int $decimals = 2): string
    {
        $sz = [
            'B',
            'Ko',
            'Mo',
            'Go',
            'To',
            'Po',
        ];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@$sz[$factor];
    }

    /**
     * Limit length of a string and sanitize.
     */
    public static function stringLimit(string|null $text, int $limit): string
    {
        $content = '';
        if ($text) {
            $isUTF8 = mb_check_encoding($text, 'UTF-8');
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $text);

            if ($isUTF8) {
                $content = trim($content);
                if ($limit && strlen($content) > $limit) {
                    $content = substr($content, 0, $limit);
                }
                $content = strip_tags($content);
                $content = Str::ascii($content);
                $content = str_replace('<<', '"', $content);
                $content = str_replace('>>', '"', $content);
                $content = trim($content);
                $content = preg_replace('/\\([^)]+\\)/', '', $content);
                $content = preg_replace('/\s\s+/', ' ', $content);
            }
        }

        return $content.'...';
    }

    /**
     * Sanitize string.
     */
    public static function hyphenize(string $string): string
    {
        $dict = [
            "I'm" => 'I am',
            // Add your own replacements here
        ];

        return strtolower(
            preg_replace(
                ['#[\\s-]+#', '#[^A-Za-z0-9. -]+#'],
                ['-', ''],
                // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
                self::cleanString(
                    str_replace( // preg_replace can be used to support more complicated replacements
                        array_keys($dict),
                        array_values($dict),
                        urldecode($string)
                    )
                )
            )
        );
    }

    /**
     * Clean accents and special characters of string.
     */
    public static function cleanString(string $text): string
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        ];

        $string = preg_replace(array_keys($utf8), array_values($utf8), $text);

        return $string ? $string : '';
    }
}
