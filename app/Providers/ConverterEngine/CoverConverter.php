<?php

namespace App\Providers\ConverterEngine;

use App\Models\Book;
use App\Utils\MediaTools;
use App\Utils\BookshelvesTools;
use App\Providers\ParserEngine\ParserEngine;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     *
     * @param Book $book
     */
    public static function create(ParserEngine $parser, Book $book): Book
    {
        if (! $book->getFirstMedia('books') && ! empty($parser->cover)) {
            $extension = config('bookshelves.cover_extension');
            $disk = 'books';
            try {
                $media = new MediaTools($book, $book->slug, $disk);
                $media->setMedia($parser->cover);
                $media->setColor();
            } catch (\Throwable $th) {
                BookshelvesTools::console(__METHOD__, $th);
            }
        }

        return $book;
    }
}
