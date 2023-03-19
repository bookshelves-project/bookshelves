<?php

namespace App\Engines\Book\Parser\Modules\Extractor;

use App\Engines\Book\Parser\Models\BookEntityAuthor;

class PdfExtractor extends Extractor
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
        $this->title = $this->extract('Title');
        $this->authors = $this->setAuthors();
        $this->description = $this->extract('Subject');
        $this->publisher = $this->extract('Producer');
        $this->tags = $this->setTags();
        $this->date = $this->extract('CreationDate');
        $this->pageCount = $this->extract('Pages');

        return $this;
    }

    private function extract(string $key): mixed
    {
        if (! array_key_exists($key, $this->metadata)) {
            return null;
        }

        $value = $this->metadata[$key];

        if (is_array($value)) {
            $value = reset($value);
        }

        return $value;
    }

    /**
     * @return BookEntityAuthor[]
     */
    private function setAuthors(): array
    {
        $current = $this->extract('Creator');

        if (! $current) {
            return [];
        }

        $list = [];
        $authors[] = $current;

        if (str_contains($current, ',')) {
            $authors = explode(',', $current);
        }

        if (str_contains($current, '&')) {
            $authors = explode('&', $current);
        }

        foreach ($authors as $author) {
            $list[] = new BookEntityAuthor($author, 'aut');
        }

        return $list;
    }

    /**
     * @return string[]
     */
    private function setTags(): array
    {
        $keywords = $this->extract('Keywords');

        if (! $keywords) {
            return [];
        }

        $subjects[] = $keywords;

        if (str_contains($keywords, ',')) {
            $subjects = explode(',', $keywords);
        }

        if (str_contains($keywords, '&')) {
            $subjects = explode('&', $keywords);
        }

        return $subjects;
    }
}
