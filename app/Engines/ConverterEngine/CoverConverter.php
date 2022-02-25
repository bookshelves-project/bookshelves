<?php

namespace App\Engines\ConverterEngine;

use App\Models\Book;
use App\Engines\ParserEngine;
use App\Services\MediaService;
use App\Services\ConsoleService;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     */
    public static function create(ParserEngine $parser, Book $book): Book
    {
        if (! empty($parser->cover_file)) {
            $disk = 'books';

            try {
                MediaService::create($book, $book->slug, $disk)
                    ->setMedia($parser->cover_file)
                    ->setColor()
                ;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, $th, true);
            }
        }

        return $book;
    }
}
