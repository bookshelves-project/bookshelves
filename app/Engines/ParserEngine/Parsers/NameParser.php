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
     * Example: `La_Longue_Guerre.Terry_Pratchett&Stephen_Baxter.La_Longue_Terre.2.fr.2017-02-09.Pocket.9782266266284`
     * like `Original_Title.Author_Name&Other_Author_Name.Serie_Title.Volume.Language.Date.Publisher.Identifier`
     */
    public static function parse(ParserEngine $parser): ParserEngine
    {
        $filename = pathinfo($parser->file_name, PATHINFO_FILENAME);
        $parsing = explode('.', $filename);

        if (is_array($parsing)) {
            $data = [];

            $list = [
                'title',
                'creators',
                'serie',
                'volume',
                'language',
                'date',
                'publisher',
                'identifiers',
            ];
            foreach ($list as $key => $value) {
                $data[$value] = self::parseName($parsing, $key);
            }

            $parser->title = self::transformToString($data['title']);
            $parser->creators = self::extractCreators($data['creators']);
            $parser->serie = self::transformToString($data['serie']);
            $parser->volume = intval($data['volume']);
            $parser->language = self::nullValueCheck($data['language']);
            $parser->date = self::nullValueCheck($data['date']);
            $parser->publisher = self::nullValueCheck($data['publisher']);
            $parser->identifiers = self::extractIdentifiers($data['identifiers']);
        }

        return $parser;
    }

    private static function parseName(array $parsing, int $key): ?string
    {
        return array_key_exists($key, $parsing) ? self::nullValueCheck($parsing[$key]) : null;
    }

    private static function transformToString(?string $attribute): string
    {
        return self::nullValueCheck(str_replace('_', ' ', $attribute));
    }

    private static function extractCreators(?string $creators): array
    {
        $list = [];
        if ($creators) {
            $creators = explode('&', $creators);

            foreach ($creators as $creator) {
                array_push($list, new BookCreator(self::transformToString($creator), 'aut'));
            }
        }

        return $list;
    }

    private static function extractIdentifiers(?string $identifiers = null): array
    {
        if ($identifiers) {
            $list = [];
            $identifiers = explode('&', $identifiers);

            foreach ($identifiers as $identifier) {
                array_push($list, new BookIdentifier('isbn13', self::transformToString($identifier)));
            }

            return $list;
        }

        return [];
    }

    private static function nullValueCheck($value)
    {
        return 'null' === $value ? null : $value;
    }
}
