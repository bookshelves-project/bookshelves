<?php

namespace App\Services\ConverterEngine;

use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Services\ParserEngine\ParserEngine;
use Illuminate\Support\Collection;

class ConverterEngine
{
    public function __construct(
        public Book $book,
        public ?Collection $authors = null,
        public ?Collection $tags = null,
        public ?Publisher $publisher = null,
        public ?Language $language = null,
        public ?Serie $serie = null,
    ) {
        if (! $this->authors) {
            $this->authors = collect([]);
        }
        if (! $this->tags) {
            $this->tags = collect([]);
        }
        if (! $this->publisher) {
            $this->publisher = new Publisher();
        }
        if (! $this->language) {
            $this->language = new Language();
        }
        if (! $this->serie) {
            $this->serie = new Serie();
        }
    }

    public static function create(ParserEngine $parser, bool $default): void
    {
        $book = Book::whereSlug($parser->slug_lang)->first();
        if (! $book) {
            $book = BookConverter::create($parser);
            AuthorConverter::generate($parser, $book);
            TagConverter::create($parser, $book);
            PublisherConverter::create($parser, $book);
            $language = LanguageConverter::create($parser);
            $book->language()->associate($language);
            SerieConverter::create($parser, $book);
            $book->refresh();
            BookIdentifierConverter::create($parser, $book);
            $book->save();

            if (! $default) {
                $book = CoverConverter::create($parser, $book);
            }

            BookConverter::epub($book, $parser->epubPath);

            // $engine = new ConverterEngine(
            //     book: $book,
            //     authors: $authors ? $authors : null,
            //     tags: $tags ? $tags : null,
            //     publisher: $publisher ? $publisher : null,
            //     language: $language,
            //     serie: $serie ? $serie : null,
            //     identifier: $identifier ? $identifier : null,
            // );

            // return $engine;
        }

        // return false;
    }
}
