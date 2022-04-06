<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Enums\MediaCollectionEnum;
use App\Enums\MediaDiskEnum;
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
            try {
                MediaService::create($book, $book->slug, MediaDiskEnum::cover)
                    ->setMedia($parser->cover_file)
                    ->setColor()
                ;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, 'red', $th);
                ConsoleService::newLine();
            }
        }

        return $book;
    }
}
