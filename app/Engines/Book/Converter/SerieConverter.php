<?php

namespace App\Engines\Book\Converter;

use App\Engines\Book\Converter\Modules\SerieModule;
use App\Models\Serie;
use Illuminate\Support\Facades\Log;
use Kiwilan\Steward\Utils\Wikipedia;

/**
 * Improve Serie with additional data.
 */
class SerieConverter
{
    public function __construct(
        public Serie $serie,
    ) {
    }

    public static function make(Serie $serie): self
    {
        $self = new SerieConverter($serie);
        $self->setTags();
        $self->setCover();
        $self->wikipedia();

        return $self;
    }

    private function wikipedia(): self
    {
        Log::info("Wikipedia: serie {$this->serie->title}");
        $wikipedia = Wikipedia::make($this->serie->title)
            ->withImage()
            ->get();
        $item = $wikipedia->getItem();

        if (! $item) {
            return $this;
        }

        $this->serie->description = $item->getExtract();
        $this->serie->link = $item->getFullUrl();
        $this->serie->save();

        return $this;
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

        return $this;
    }
}
