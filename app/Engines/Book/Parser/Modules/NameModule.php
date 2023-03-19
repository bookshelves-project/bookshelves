<?php

namespace App\Engines\Book\Parser\Modules;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Engines\Book\Parser\Models\BookEntityIdentifier;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Book\Parser\Parsers\NameParser;
use App\Engines\Book\ParserEngine;

class NameModule extends ParserModule implements ParserModuleInterface
{
    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = ParserModule::create($parser, self::class, $debug);

        return NameParser::make($self)
            ->execute()
        ;
    }

    public function parse(array $metadata): ParserModule
    {
        $this->title = $this->transformToString($metadata['title']);
        $this->authors = $this->extractCreators($metadata['creators']);
        $this->language = NameParser::nullValueCheck($metadata['language']);
        $this->serie = $this->transformToString($metadata['serie']);
        $this->volume = intval($metadata['volume']);
        $this->date = NameParser::nullValueCheck($metadata['date']);
        $this->publisher = NameParser::nullValueCheck($metadata['publisher']);
        $this->identifiers = $this->extractIdentifiers($metadata['identifiers']);

        return $this;
    }

    private function transformToString(?string $attribute): string
    {
        return NameParser::nullValueCheck(str_replace('_', ' ', $attribute));
    }

    private function extractCreators(?string $creators): array
    {
        if (! $creators) {
            return [];
        }

        $list = [];
        $creators = explode('&', $creators);

        foreach ($creators as $creator) {
            array_push($list, new BookEntityAuthor($this->transformToString($creator), 'aut'));
        }

        return $list;
    }

    private function extractIdentifiers(?string $identifiers = null): array
    {
        if (! $identifiers) {
            return [];
        }

        $list = [];
        $identifiers = explode('&', $identifiers);

        foreach ($identifiers as $identifier) {
            $list[] = new BookEntityIdentifier('isbn13', $this->transformToString($identifier));
        }

        return $list;
    }
}
