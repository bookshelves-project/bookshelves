<?php

namespace App\Providers\BookshelvesConverterEngine;

use App\Models\Book;
use App\Models\Serie;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Identifier;
use Illuminate\Support\Collection;
use App\Providers\EbookParserEngine\EbookParserEngine;

/**
 *
 * @package App\Providers\BookshelvesConverterEngine
 */
class BookshelvesConverterEngine
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

    public static function create(EbookParserEngine $epe, bool $local, bool $default): BookshelvesConverterEngine|false
    {
        $book = Book::whereSlug($epe->slug_lang)->first();
        if (! $book) {
            $book = BookConverter::create($epe);
            $authors = AuthorConverter::generate($epe, $book);
            $tags = TagConverter::create($epe, $book);
            $publisher = PublisherConverter::create($epe, $book);
            $language = LanguageConverter::create($epe);
            $serie = SerieConverter::create($epe, $book);
            $book->refresh();
            $book->language()->associate($language->slug);
            $identifier = IdentifierConverter::create($epe, $book);
            $book->save();
            
            if (! $default) {
                $book = CoverConverter::create($epe, $book);
            }

            BookConverter::epub($book, $epe->epubPath);

            $engine = new BookshelvesConverterEngine(
                book: $book,
                authors: $authors ? $authors : null,
                tags: $tags ? $tags : null,
                publisher: $publisher ? $publisher : null,
                language: $language,
                serie: $serie ? $serie : null,
                identifier: $identifier ? $identifier : null,
            );

            return $engine;
        }

        return false;
    }
}
