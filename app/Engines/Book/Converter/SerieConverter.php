<?php

namespace App\Engines\Book\Converter;

use App\Engines\Book\Converter\Modules\SerieModule;
use App\Facades\Bookshelves;
use App\Models\Serie;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\Wikipedia;

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
        $self = new SerieConverter($serie, $fresh);
        $self->setTags();
        $self->setCover();
        if (Bookshelves::apiWikipedia()) {
            $self->wikipedia();
        }

        $self->setBookDescription();

        return $self;
    }

    private function wikipedia(): self
    {
        Journal::info("Wikipedia: serie {$this->serie->title}");

        $lang = BookConverter::selectLang($this->serie->books);
        $wikipedia = Wikipedia::make($this->serie->title)
            ->language($lang)
            ->exact()
            ->withImage()
            ->get();

        $item = $wikipedia->getItem();
        $this->serie->wikipedia_parsed_at = now();

        if (! $item) {
            $this->serie->save();

            return $this;
        }

        $this->serie->description = $item->getExtract();
        $this->serie->link = $item->getFullUrl();

        $this->serie->save();

        return $this;
    }

    private function setBookDescription(): void
    {
        if (! $this->serie->description) {
            $books = $this->serie->load('books')->books;
            $this->serie->description = $books->first()->description;
            $this->serie->save();
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
            $this->serie->save();
        });

        return $this;
    }
}
