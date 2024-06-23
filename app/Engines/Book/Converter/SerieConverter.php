<?php

namespace App\Engines\Book\Converter;

use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\Serie;
use Kiwilan\Steward\Utils\SpatieMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Improve Serie with additional data.
 */
class SerieConverter
{
    protected function __construct(
        protected Serie $serie,
        protected bool $fresh = false,
    ) {}

    public static function make(Serie $serie, bool $fresh = false): self
    {
        $self = new self($serie, $fresh);
        $self->setTags();
        $self->setCover();
        $self->setBookDescription();

        $serie->api_parsed_at = now();
        $self->serie->saveNoSearch();

        return $self;
    }

    private function setBookDescription(): void
    {
        if ($this->fresh) {
            $this->serie->description = null;
        }

        if (! $this->serie->description) {
            $books = $this->serie->load('books')->books;
            $volume01 = $books->where('volume', 1)->first();
            if ($volume01) {
                $this->serie->description = $volume01->description;
            } else {
                $this->serie->description = $books->first()->description;
            }
            $this->serie->saveNoSearch();
        }
    }

    private function setCover(): self
    {
        if ($this->fresh) {
            $this->serie->clearCover();
        }

        if (! $this->serie->hasCover()) {
            $book = Book::query()
                ->where('volume', 1)
                ->where('serie_id', $this->serie->id)
                ->first();

            if (! $book) {
                $book = Book::query()
                    ->where('serie_id', $this->serie->id)
                    ->first();
            }

            /** @var Media|null $media */
            $media = $book->cover_media;
            if (! $media) {
                return $this;
            }

            $file = $media->getPath();
            SpatieMedia::make($this->serie)
                ->addMediaFromString(file_get_contents($file))
                ->collection(Bookshelves::imageCollection())
                ->disk(Bookshelves::imageDisk())
                ->color()
                ->save();
        }

        return $this;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    private function setTags(): self
    {
        if ($this->fresh) {
            $this->serie->tags()->detach();
            $this->serie->saveNoSearch();
        }

        if ($this->serie->tags->isNotEmpty()) {
            return $this;
        }

        $books = $this->serie->load('books.tags')->books;
        $tags = [];

        foreach ($books as $book) {
            foreach ($book->tags as $tag) {
                $tags[] = $tag->id;
            }
        }

        $tags = array_unique($tags);

        if (! $tags) {
            return $this;
        }

        $this->serie->tags()->sync($tags);
        $this->serie->saveNoSearch();

        return $this;
    }
}
