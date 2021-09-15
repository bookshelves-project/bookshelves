<?php

namespace App\Providers\BookshelvesConverter;

use App\Models\Book;
use App\Providers\ImageProvider;
use Illuminate\Support\Facades\Storage;
use App\Providers\EbookParserEngine\EbookParserEngine;

class CoverConverter
{
    /**
     * Generate JPG for Book from EbookParserEngine, use only during generation.
     */
    public static function rawCover(EbookParserEngine $EPE, Book $book)
    {
        try {
            Storage::disk('public')->put("/raw/covers/$book->id.jpg", $EPE->cover);
        } catch (\Throwable $th) {
            //throw $th;
            dump($th);
        }
    }
    
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     *
     * @param Book $book
     */
    public static function cover(Book $book): Book
    {
        $cover = Storage::disk('public')->get("/raw/covers/$book->id.jpg");

        if (! $book->image) {
            $disk = 'books';
            try {
                $book->addMediaFromString($cover)
                    ->setName($book->slug)
                    ->setFileName($book->slug . '.' . config('bookshelves.cover_extension'))
                    ->toMediaCollection($disk, $disk);

                $book = $book->refresh();

                // Get color
                $image = $book->getFirstMediaPath('books');
                $color = ImageProvider::simple_color_thief($image);
                $media = $book->getFirstMedia('books');
                $media->setCustomProperty('color', $color);
                $media->save();
            } catch (\Throwable $th) {
                //throw $th;
                echo "Can't convert cover for $book->title\n";
                // dump($th);
                $book->clearMediaCollection('books');
            }
        }

        return $book;
    }
}
