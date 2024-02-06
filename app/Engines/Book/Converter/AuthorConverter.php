<?php

namespace App\Engines\Book\Converter;

use App\Facades\Bookshelves;
use App\Models\Author;
use Kiwilan\Notifier\Facades\Journal;
use Kiwilan\Steward\Utils\SpatieMedia;
use Kiwilan\Steward\Utils\Wikipedia;

/**
 * Improve Author with additional data.
 */
class AuthorConverter
{
    protected function __construct(
        protected Author $author,
        protected bool $fresh = false,
    ) {
    }

    public static function make(Author $author, bool $fresh = false): self
    {
        $self = new AuthorConverter($author, $fresh);
        if (Bookshelves::apiWikipedia()) {
            $self->wikipedia();
        }

        return $self;
    }

    private function wikipedia(): self
    {
        Journal::info("Wikipedia: author {$this->author->name}");

        $lang = BookConverter::selectLang($this->author->books);
        $wikipedia = Wikipedia::make($this->author->name)->language($lang);

        if (Bookshelves::authorWikipediaExact()) {
            $wikipedia->exact();
        }

        $wikipedia->withImage()
            ->get();

        $item = $wikipedia->getItem();
        $this->author->wikipedia_parsed_at = now();

        if (! $item) {
            $this->author->save();

            return $this;
        }

        Author::withoutSyncingToSearch(function () use ($item) {
            $this->author->description = $item->getExtract();
            $this->author->link = $item->getFullUrl();
            $this->author->save();
        });

        $picture = $item->getPictureBase64();
        if ($picture) {
            $this->author->clearMediaCollection(Bookshelves::imageCollection());
            SpatieMedia::make($this->author)
                ->addMediaFromBase64($picture)
                ->collection(Bookshelves::imageCollection())
                ->disk(Bookshelves::imageDisk())
                ->color()
                ->save();
        }

        return $this;
    }
}
