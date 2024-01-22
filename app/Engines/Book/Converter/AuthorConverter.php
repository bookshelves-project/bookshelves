<?php

namespace App\Engines\Book\Converter;

use App\Facades\Bookshelves;
use App\Models\Author;
use Illuminate\Support\Facades\Log;
use Kiwilan\Steward\Utils\SpatieMedia;
use Kiwilan\Steward\Utils\Wikipedia;

/**
 * Improve Author with additional data.
 */
class AuthorConverter
{
    public function __construct(
        public Author $author,
    ) {
    }

    public static function make(Author $author): self
    {
        $self = new AuthorConverter($author);
        $self->wikipedia();

        return $self;
    }

    private function wikipedia(): self
    {
        Log::info("Wikipedia: author {$this->author->name}");
        $wikipedia = Wikipedia::make($this->author->name);

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

        $this->author->description = $item->getExtract();
        $this->author->link = $item->getFullUrl();
        $this->author->save();

        $picture = $item->getPictureBase64();
        if ($picture) {
            $this->author->clearMediaCollection('covers');
            SpatieMedia::make($this->author)
                ->addMediaFromBase64($picture)
                ->disk('covers')
                ->collection('covers')
                ->save();
        }

        return $this;
    }
}
