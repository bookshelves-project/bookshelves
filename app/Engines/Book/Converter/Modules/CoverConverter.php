<?php

namespace App\Engines\Book\Converter\Modules;

use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Utils\SpatieMedia;
use Spatie\Image\Image;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     */
    public static function make(Ebook $ebook, Book $book): Book
    {
        if (! $ebook->hasCover()) {
            Log::warning("No cover for {$book->title}");

            return $book;
        }

        SpatieMedia::make($book)
            ->addMediaFromString($ebook->getCover()->getContents())
            ->extension('avif')
            ->collection('covers')
            ->disk('covers_original')
            ->color()
            ->save();

        return $book;
    }
}
