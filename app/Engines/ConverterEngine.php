<?php

namespace App\Engines;

use App\Engines\ConverterEngine\AuthorConverter;
use App\Engines\ConverterEngine\BookConverter;
use App\Engines\ConverterEngine\BookIdentifierConverter;
use App\Engines\ConverterEngine\CoverConverter;
use App\Engines\ConverterEngine\LanguageConverter;
use App\Engines\ConverterEngine\PublisherConverter;
use App\Engines\ConverterEngine\SerieConverter;
use App\Engines\ConverterEngine\TagConverter;
use App\Enums\BookFormatEnum;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
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
            LanguageConverter::create($parser, $book);
            SerieConverter::create($parser, $book);
            BookIdentifierConverter::create($parser, $book);

            if (! $default) {
                $book = CoverConverter::create($parser, $book);
            }

            match ($parser->format) {
                BookFormatEnum::epub() => BookConverter::epub($book, $parser->file_path),
                default => BookConverter::epub($book, $parser->file_path),
            };
            $book->save();

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
