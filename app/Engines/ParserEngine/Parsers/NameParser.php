<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Engines\ParserEngine\Models\BookIdentifier;
use App\Enums\BookTypeEnum;

class NameParser
{
    /**
     * Parse file name to generate Book.
     *
     * Example: `novel.La_Longue_Guerre.Terry_Pratchett&Stephen_Baxter.La_Longue_Terre.2.fr.2017-02-09.Pocket.9782266266284` like `BookTypeEnum.Original_Title.Author&Other_Author.Serie_Title.Volume.Language.Date.Publisher.Identifier`
     */
    public static function parse(ParserEngine $parser): ParserEngine
    {
        $filename = pathinfo($parser->file_name, PATHINFO_FILENAME);
        $parsing = explode('.', $filename);

        if (is_array($parsing)) {
            $data = [];
            foreach ($parsing as $value) {
                $data['type'] = self::parseName($parsing, 0) ?? BookTypeEnum::novel->value;
                $data['title'] = self::parseName($parsing, 1);
                $data['creators'] = self::parseName($parsing, 2);
                $data['serie'] = self::parseName($parsing, 3);
                $data['volume'] = self::parseName($parsing, 4);
                $data['language'] = self::parseName($parsing, 5);
                $data['date'] = self::parseName($parsing, 6);
                $data['publisher'] = self::parseName($parsing, 7);
                $data['identifiers'] = self::parseName($parsing, 8);
            }

            $parser->type = BookTypeEnum::from($data['type']);
            $parser->title = self::transformToString($data['title']);
            $parser->creators = self::extractCreators($data['creators']);
            $parser->serie = self::transformToString($data['serie']);
            $parser->volume = intval($data['volume']);
            $parser->language = $data['language'];
            $parser->date = $data['date'];
            $parser->publisher = $data['publisher'];
            $parser->identifiers = self::extractIdentifiers($data['identifiers']);
        }

        return $parser;
    }

    private static function parseName(array $parsing, int $key): ?string
    {
        return array_key_exists($key, $parsing) ? $parsing[$key] : null;
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
