<?php

namespace App\Providers\Bookshelves;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use App\Providers\MetadataExtractor\MetadataExtractor;

class CoverGenerator
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     *
     * @param MetadataExtractor $metadataExtractor
     *
     * @return Book
     */
    public static function run(Book $book, ?bool $isDebug = false): Book
    {
        $cover = Storage::disk('public')->get("/covers-raw/$book->id.jpg");

        if (! $book->image) {
            $disk = 'books';
            $book->addMediaFromString($cover)
                ->setName($book->slug)
                ->setFileName($book->slug.'.'.config('bookshelves.cover_extension'))
                ->toMediaCollection($disk, $disk);

            $book = $book->refresh();
        }

        return $book;
    }
}
