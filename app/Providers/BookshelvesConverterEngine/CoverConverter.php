<?php

namespace App\Providers\BookshelvesConverterEngine;

use App\Models\Book;
use App\Utils\MediaTools;
use App\Utils\BookshelvesTools;
use App\Providers\EbookParserEngine\EbookParserEngine;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     *
     * @param Book $book
     */
    public static function create(EbookParserEngine $EPE, Book $book): Book
    {
        if (! $book->getFirstMedia('books') && ! empty($EPE->cover)) {
            $extension = config('bookshelves.cover_extension');
            $disk = 'books';
            try {
                $media = new MediaTools($book, $book->slug, $disk);
                $media->setMedia($EPE->cover);
                $media->setColor();
            } catch (\Throwable $th) {
                BookshelvesTools::console(__METHOD__, $th);
            }
        }

        return $book;
    }
}
