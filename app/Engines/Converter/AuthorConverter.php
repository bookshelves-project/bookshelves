<?php

namespace App\Engines\Converter;

use App\Engines\Book\BookUtils;
use App\Facades\Bookshelves;
use App\Models\Author;
use Kiwilan\LaravelNotifier\Facades\Journal;
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
    ) {}

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
        $this->author->clearCover();

        $lang = BookUtils::selectLang($this->author->books);
        $wikipedia = Wikipedia::make($this->author->name)->language($lang);
        $this->author->api_parsed_at = now();

        if (Bookshelves::authorWikipediaExact()) {
            $wikipedia->exact();
        }

        $wikipedia->withImage()
            ->get();

        $exists = $wikipedia->isAvailable();
        Journal::debug("AuthorConverter: author {$this->author->name} ".($exists ? 'exists' : 'not found')." in {$lang}");

        if (! $exists) {
            $this->author->save();

            return $this;
        }

        $item = $wikipedia->getItem();
        $this->author->api_exists = $exists;

        if (! $item) {
            $this->author->save();

            return $this;
        }

        $this->author->description = $item->getExtract();
        $this->author->link = $item->getFullUrl();
        $this->author->saveNoSearch();

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
