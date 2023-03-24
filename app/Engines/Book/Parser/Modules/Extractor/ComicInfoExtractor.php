<?php

namespace App\Engines\Book\Parser\Modules\Extractor;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use Illuminate\Support\Carbon;

class ComicInfoExtractor extends Extractor
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
        if (! $this->metadata) {
            return $this;
        }

        $this->title = $this->extract('Title');
        $this->description = $this->extract('Summary');
        $this->serie = $this->extract('Series');
        $volume = $this->extract('Number');
        $this->volume = $volume ? (int) $volume : null;
        $this->publisher = $this->extract('Publisher');
        $this->language = $this->extract('LanguageISO');
        $this->authors = $this->setCreators('Writer');
        $this->date = $this->setDate();

        $this->cover->setIsExists();
        $this->cover->setIsFirst();

        return $this;
    }

    private function extract(string $extractKey): ?string
    {
        return array_key_exists($extractKey, $this->metadata)
            ? $this->metadata[$extractKey]
            : null;
    }

    /**
     * @return array<BookEntityAuthor>
     */
    private function setCreators(string $extractKey): array
    {
        if (! array_key_exists($extractKey, $this->metadata)) {
            return [];
        }

        $items = [];
        $creators = explode(',', $this->metadata[$extractKey]);

        foreach ($creators as $creator) {
            $creator = new BookEntityAuthor(trim($creator), 'aut');
            $items[] = $creator;
        }

        return $items;
    }

    private function setDate(): ?string
    {
        $date = null;
        $year = null;
        $month = null;
        $day = null;

        if (array_key_exists('Year', $this->metadata)) {
            $year = $this->metadata['Year'];
        }

        if (array_key_exists('Month', $this->metadata)) {
            $month = $this->metadata['Month'];
        }

        if (array_key_exists('Day', $this->metadata)) {
            $day = $this->metadata['Day'];
        }

        if ($year || $month || $day) {
            $date = Carbon::createFromDate($year, $month, $day);
            $date = $date->format('Y-m-d');
        }

        return $date;
    }
}
