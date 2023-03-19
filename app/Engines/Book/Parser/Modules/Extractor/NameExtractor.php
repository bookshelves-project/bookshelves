<?php

namespace App\Engines\Book\Parser\Modules\Extractor;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Engines\Book\Parser\Models\BookEntityIdentifier;

class NameExtractor extends Extractor
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public static function make(array $metadata): self
    {
        $self = new self();
        $self->metadata = $metadata;
        $self->parse();

        return $self;
    }

    private function parse(): self
    {
        $this->title = $this->transformToString($this->metadata['title']);
        $this->authors = $this->extractCreators($this->metadata['creators']);
        $this->language = NameExtractor::nullValueCheck($this->metadata['language']);
        $this->serie = $this->transformToString($this->metadata['serie']);
        $this->volume = intval($this->metadata['volume']);
        $this->date = NameExtractor::nullValueCheck($this->metadata['date']);
        $this->publisher = NameExtractor::nullValueCheck($this->metadata['publisher']);
        $this->identifiers = $this->extractIdentifiers($this->metadata['identifiers']);

        return $this;
    }

    private function transformToString(?string $attribute): string
    {
        return NameExtractor::nullValueCheck(str_replace('_', ' ', $attribute));
    }

    /**
     * @return BookEntityAuthor[]
     */
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

    /**
     * @return BookEntityIdentifier[]
     */
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

    public static function nullValueCheck(?string $value): ?string
    {
        return 'null' === $value ? null : $value;
    }
}
