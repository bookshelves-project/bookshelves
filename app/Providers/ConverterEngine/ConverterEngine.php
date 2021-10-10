<?php

namespace App\Providers\ConverterEngine;

use App\Models\Book;
use App\Models\Identifier;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Providers\ParserEngine\ParserEngine;
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
        public ?Identifier $identifier = null,
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
        if (! $this->identifier) {
            $this->identifier = new Identifier();
        }
    }

    public static function create(ParserEngine $parser, bool $local, bool $default): void
    {
        $book = Book::whereSlug($parser->slug_lang)->first();
        if (! $book) {
            $book = BookConverter::create($parser);
            $authors = AuthorConverter::generate($parser, $book);
            $tags = TagConverter::create($parser, $book);
            $publisher = PublisherConverter::create($parser, $book);
            $language = LanguageConverter::create($parser);
            $serie = SerieConverter::create($parser, $book);
            $book->refresh();
            $book->language()->associate($language->slug);
            $identifier = IdentifierConverter::create($parser, $book);
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
