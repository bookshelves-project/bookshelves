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
        // config('QUEUE_CONNECTION', 'database');
        // dump(config('queue.default'));

        if (! $book->getFirstMedia('books') && ! empty($parser->cover)) {
            $disk = 'books';

            try {
                $media = new MediaService(model: $book, name: $book->slug, disk: $disk);
                $media->setMedia($parser->cover);
                $media->setColor();
            } catch (\Throwable $th) {
                BookshelvesTools::console(__METHOD__, $th);
            }
        }

        return $book;
    }
}
