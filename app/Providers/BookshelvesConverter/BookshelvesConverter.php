<?php

namespace App\Providers\BookshelvesConverter;

use App\Models\Book;
use App\Providers\EbookParserEngine\EbookParserEngine;

/**
 *
 * @package App\Providers\BookshelvesConverter
 */
class BookshelvesConverter
{
    public static function create(EbookParserEngine $EPE, bool $local): Book
    {
        $bookIsExist = Book::whereSlug($EPE->slug_lang)->first();
        if (! $bookIsExist) {
            $book = BookConverter::book($EPE);
            $book = AuthorConverter::authors($EPE, $book);
            $book = TagConverter::create($EPE, $book);
            $book = PublisherConverter::create($EPE, $book);
            $language = LanguageConverter::create($EPE);
            $book = SerieConverter::create($EPE, $book);
            CoverConverter::rawCover($EPE, $book);
            $book->language()->associate($language->slug);
            $identifier = IdentifierConverter::create($EPE, $book);
            $book->title_sort = SerieConverter::sortTitleWithSerie($book);
            $book->save();

            if (! $local && $identifier) {
                GoogleBookConverter::create(identifier: $identifier, book: $book);
            }

            $bookIsExist = $book;
        }

        return $bookIsExist;
    }
}
