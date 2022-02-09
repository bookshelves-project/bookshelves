<?php

namespace App\Services\ConverterEngine;

use App\Models\Book;
use App\Services\MediaService;
use App\Services\ParserEngine\ParserEngine;
use App\Utils\BookshelvesTools;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     */
    public static function create(ParserEngine $parser, Book $book): Book
    {
        if (! empty($parser->cover)) {
            $disk = 'books';

            try {
                MediaService::create($book, $book->slug, $disk)
                    ->setMedia($parser->cover)
                    ->setColor()
                ;
            } catch (\Throwable $th) {
                BookshelvesTools::console(__METHOD__, $th);
            }
        }

        return $book;
    }
}
