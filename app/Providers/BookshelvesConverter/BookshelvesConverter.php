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
    public static function create(EbookParserEngine $EPE, bool $local, bool $default): Book
    {
        $bookIsExist = Book::whereSlug($EPE->slug_lang)->first();
        if (! $bookIsExist) {
            $book = BookConverter::create($EPE);
            $book = AuthorConverter::generate($EPE, $book);
            $book = TagConverter::create($EPE, $book);
            $book = PublisherConverter::create($EPE, $book);
            $language = LanguageConverter::create($EPE);
            $serie = SerieConverter::create($EPE, $book);
            if ($serie) {
                $serie = SerieConverter::setTags($serie);
            }
            $book->refresh();
            $book->language()->associate($language->slug);
            $identifier = IdentifierConverter::create($EPE, $book);
            $book->save();
            
            if (! $default) {
                $book = CoverConverter::create($EPE, $book);
                if ($serie) {
                    $serie = SerieConverter::setCover($serie);
                }
            }

            BookConverter::epub($book, $EPE->epubPath);
            

            $bookIsExist = $book;
        }

        return $bookIsExist;
    }
}
