<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Models\Book;
use App\Services\ConsoleService;
use App\Services\MediaService;

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
