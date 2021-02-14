<?php

namespace App\Providers\Bookshelves;

use App\Models\Book;

class CoverGenerator
{
    public static function run(array $metadata): Book
    {
        $book = $metadata['book'];
        $cover = $metadata['cover'];

        if (! $book->image) {
            $disk = 'books';
            $book->addMediaFromString($cover)
                ->setName($book->slug)
                ->setFileName($book->slug.'.jpg')
                ->toMediaCollection($disk, $disk);

            $book = $book->refresh();
        }

        return $book;
    }
}
