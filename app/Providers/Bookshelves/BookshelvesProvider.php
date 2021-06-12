<?php

namespace App\Providers\Bookshelves;

use App\Models\Book;
use Illuminate\Support\Str;
use App\Providers\MetadataExtractor\MetadataExtractor;

class BookshelvesProvider
{
    /**
     * Generate new Book with all relations.
     * If $alone is set true, no search for external informations.
     */
    public static function convertMetadata(MetadataExtractor $metadataExtractor, bool $alone): Book
    {
        $bookIfExist = Book::whereSlug(Str::slug($metadataExtractor->title, '-'))->first();
        $book = null;
        if (! $bookIfExist) {
            $book = BookProvider::book($metadataExtractor);
            $book = BookProvider::authors($metadataExtractor, $book);
            $book = BookProvider::tags($metadataExtractor, $book);
            $book = BookProvider::publisher($metadataExtractor, $book);
            $language = BookProvider::language($metadataExtractor);
            $book = BookProvider::serie($metadataExtractor, $book);
            BookProvider::rawCover($metadataExtractor, $book);
            $book->language()->associate($language->slug);
            $identifier = BookProvider::identifier($metadataExtractor, $book);
            $book->title_sort = BookProvider::sortTitleWithSerie($book);
            $book->save();

            if (! $alone && $identifier) {
                BookProvider::googleBook(identifier: $identifier, book: $book);
            }
        }
        if (! $book) {
            $book = $bookIfExist;
        }

        return $book;
    }
}
