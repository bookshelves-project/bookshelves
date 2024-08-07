<?php

namespace App\Engines\Book\Converter\Modules;

use App\Facades\Bookshelves;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Kiwilan\Ebook\Ebook;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\Picture;
use Kiwilan\Steward\Utils\SpatieMedia;
use Spatie\Image\Image;

class CoverModule
{
    /**
     * Generate Book image from original cover string file.
     */
    public static function make(Ebook $ebook, Book $book): Book
    {
        $book->clearCover();

        $self = new self;

        if (! $ebook->hasCover()) {
            Journal::warning("No cover for {$book->title}");

            return $book;
        }

        $name = uniqid().'.avif';
        $path = storage_path("app/cache/{$name}");
        $contents = $ebook->getCover()->getContents();

        File::put($path, $contents);
        $self->resize($path);
        $contents = File::get($path);

        SpatieMedia::make($book)
            ->addMediaFromString($contents)
            ->name($book->slug)
            ->extension(Bookshelves::imageFormat())
            ->collection(Bookshelves::imageCollection())
            ->disk(Bookshelves::imageDisk())
            ->color()
            ->save();

        unlink($path);

        return $book;
    }

    private function resize(string $path): void
    {
        $maxHeight = 1600;

        $media = Picture::load($path);
        $height = $media->getHeight();

        if ($height > $maxHeight) {
            $media->height($maxHeight)
                ->optimize()
                ->save();
        }
    }
}
