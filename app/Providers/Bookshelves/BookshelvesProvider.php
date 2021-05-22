<?php

namespace App\Providers\Bookshelves;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Providers\MetadataExtractor\MetadataExtractor;

class BookshelvesProvider
{
    /**
     * Generate new Book with all relations.
     *
     * @param MetadataExtractor $metadataExtractor
     *
     * @return Book
     */
    public static function convertMetadata(MetadataExtractor $metadataExtractor): Book
    {
        $bookIfExist = Book::whereSlug(Str::slug($metadataExtractor->title, '-'))->first();
        $book = null;
        if (! $bookIfExist) {
            $book = BookProvider::book($metadataExtractor);
            $book = BookProvider::authors($metadataExtractor, $book);
            $book = BookProvider::tags($metadataExtractor, $book);
            $category = Category::take(1)->first();
            $book->category()->save($category);
            $book->category($category);
            $book = BookProvider::publisher($metadataExtractor, $book);
            $book = BookProvider::serie($metadataExtractor, $book);
            BookProvider::rawCover($metadataExtractor, $book);
            $language = BookProvider::language($metadataExtractor);
            $book->language()->associate($language->slug);
            $identifier = BookProvider::identifier($metadataExtractor, $book);
            $book->save();

            BookProvider::googleBook(identifier: $identifier, book: $book);
        }
        if (! $book) {
            $book = $bookIfExist;
        }

        return $book;
    }
}
