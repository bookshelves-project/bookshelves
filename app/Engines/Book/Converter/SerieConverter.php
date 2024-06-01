<?php

namespace App\Engines\Book\Converter;

use App\Engines\Book\Converter\Modules\SerieModule;
use App\Jobs\Serie\SerieJob;
use App\Models\Serie;

/**
 * Improve Serie with additional data.
 */
class SerieConverter
{
    protected function __construct(
        protected Serie $serie,
        protected bool $fresh = false,
    ) {
    }

    public static function make(Serie $serie, bool $fresh = false): self
    {
        $self = new self($serie, $fresh);
        $self->setTags();
        $self->setCover();
        $self->setBookDescription();

        Serie::withoutSyncingToSearch(function () use ($serie) {
            $serie->api_parsed_at = now();
            $serie->saveQuietly();
        });

        SerieJob::dispatch($serie);

        return $self;
    }

    private function setBookDescription(): void
    {
        if (! $this->serie->description) {
            $books = $this->serie->load('books')->books;
            $this->serie->description = $books->first()->description;
        }
    }

    private function setCover(): self
    {
        SerieModule::setBookCover($this->serie);

        return $this;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    private function setTags(): self
    {
        if ($this->serie->tags->isNotEmpty() && ! $this->fresh) {
            return $this;
        }

        Serie::withoutSyncingToSearch(function () {
            $books = $this->serie->load('books.tags')->books;
            $tags = [];

            foreach ($books as $book) {
                foreach ($book->tags as $tag) {
                    $tags[] = $tag->id;
                }
            }

            $tags = array_unique($tags);

            $this->serie->tags()->sync($tags);
            $this->serie->saveQuietly();
        });

        return $this;
    }
}
