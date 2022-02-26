<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\BookCreator;
use App\Engines\ParserEngine\BookIdentifier;

class NameParserModule
{
    public static function parse(ParserEngine $parser): ParserEngine
    {
        $filename = pathinfo($parser->file_name, PATHINFO_FILENAME);
        $parsing = explode('.', $filename);

        if (is_array($parsing)) {
            $parser->title = self::transformToString($parsing[0]);
            $parser->creators = array_key_exists(1, $parsing) ? self::extractCreators($parsing[1]) : [];
            $parser->serie = array_key_exists(2, $parsing) ? self::transformToString($parsing[2]) : null;
            $parser->volume = array_key_exists(3, $parsing) ? intval($parsing[3]) : null;
            $parser->language = array_key_exists(4, $parsing) ? $parsing[4] : null;
            $parser->date = array_key_exists(5, $parsing) ? $parsing[5] : null;
            $parser->publisher = array_key_exists(6, $parsing) ? $parsing[6] : null;
            $parser->identifiers = array_key_exists(7, $parsing) ? self::extractIdentifiers($parsing[7]) : [];
        }

        return $parser;
    }

    private static function transformToString(string $attribute): string
    {
        return str_replace('_', ' ', $attribute);
    }

    private static function extractCreators(string $creators): array
    {
        $list = [];
        $creators = explode('&', $creators);

        foreach ($creators as $creator) {
            array_push($list, new BookCreator(self::transformToString($creator), 'aut'));
        }

        return $list;
    }

    private static function extractIdentifiers(string $identifiers): array
    {
        $list = [];
        $identifiers = explode('&', $identifiers);

        foreach ($identifiers as $identifier) {
            array_push($list, new BookIdentifier('isbn13', self::transformToString($identifier)));
        }

        return $list;
    }
}
