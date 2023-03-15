<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Engines\ParserEngine\Models\BookIdentifier;

class NameParser
{
    /** @var BookCreator[] */
    public ?array $creators = [];

    /** @var BookIdentifier[] */
    public ?array $identifiers = null;

    public function __construct(
        public ParserEngine $engine,
        public ?string $title = null,
        public ?string $language = null,
        public ?string $serie = null,
        public ?int $volume = null,
        public ?string $date = null,
        public ?string $publisher = null,
    ) {
    }

    /**
     * Parse file name to generate Book.
     *
     * Example: `La_Longue_Guerre.Terry_Pratchett&Stephen_Baxter.fr.La_Longue_Terre.2.Pocket.2017-02-09.9782266266284`
     * like `Original_Title.Author_Name&Other_Author_Name.Language.Serie_Title.Volume.Publisher.Date.Identifier`
     */
    public static function make(ParserEngine $parser_engine): ParserEngine
    {
        $filename = pathinfo($parser_engine->file_name, PATHINFO_FILENAME);
        $parsing = explode('.', $filename);

        if (is_array($parsing)) {
            $data = [];

            $list = [
                'title',
                'creators',
                'language',
                'serie',
                'volume',
                'publisher',
                'date',
                'identifiers',
            ];

            foreach ($list as $key => $value) {
                $data[$value] = NameParser::parseName($parsing, $key);
            }

            $name_parser = new NameParser($parser_engine);
            $name_parser->title = NameParser::transformToString($data['title']);
            $name_parser->creators = NameParser::extractCreators($data['creators']);
            $name_parser->language = NameParser::nullValueCheck($data['language']);
            $name_parser->serie = NameParser::transformToString($data['serie']);
            $name_parser->volume = intval($data['volume']);
            $name_parser->date = NameParser::nullValueCheck($data['date']);
            $name_parser->publisher = NameParser::nullValueCheck($data['publisher']);
            $name_parser->identifiers = NameParser::extractIdentifiers($data['identifiers']);

            $parser_engine->title = $name_parser->assignIfNull('title');
            $parser_engine->creators = $name_parser->assignIfNull('creators');
            $parser_engine->language = $name_parser->assignIfNull('language');
            $parser_engine->serie = $name_parser->assignIfNull('serie');
            $parser_engine->volume = $name_parser->assignIfNull('volume');
            $parser_engine->date = $name_parser->assignIfNull('date');
            $parser_engine->publisher = $name_parser->assignIfNull('publisher');
            $parser_engine->identifiers = $name_parser->assignIfNull('identifiers');
        }

        return $parser_engine;
    }

    private function assignIfNull(string $property): mixed
    {
        if (! is_array($this->engine->{$property})) {
            return null === $this->engine->{$property} ? $this->{$property} : $this->engine->{$property};
        }

        return [] === $this->engine->{$property} ? $this->{$property} : $this->engine->{$property};
    }

    private static function parseName(array $parsing, int $key): ?string
    {
        return array_key_exists($key, $parsing) ? NameParser::nullValueCheck($parsing[$key]) : null;
    }

    private static function transformToString(?string $attribute): string
    {
        return NameParser::nullValueCheck(str_replace('_', ' ', $attribute));
    }

    private static function extractCreators(?string $creators): array
    {
        $list = [];

        if (null !== $creators) {
            $creators = explode('&', $creators);

            foreach ($creators as $creator) {
                array_push($list, new BookCreator(NameParser::transformToString($creator), 'aut'));
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
                array_push($list, new BookIdentifier('isbn13', NameParser::transformToString($identifier)));
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
