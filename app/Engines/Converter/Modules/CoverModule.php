<?php

namespace App\Engines\Converter\Modules;

use App\Facades\Bookshelves;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\Picture;
use Kiwilan\Steward\Utils\SpatieMedia;
use Spatie\Image\Image;

class CoverModule
{
    /**
     * Generate Book image from original cover string file.
     */
    public static function make(Book $book): Book
    {
        $book->clearCover();

        $self = new self;
        $path = $book->getIndexCoverPath();

        if (! file_exists($path)) {
            Journal::warning("No cover for {$book->title}", [
                'path' => $path,
            ]);

            return $book;
        }

        $name = uniqid().'.avif';
        $temp_path = storage_path("app/cache/{$name}");
        $contents = file_get_contents($path);

        File::put($temp_path, $contents);
        $self->resize($temp_path);
        $contents = File::get($temp_path);

        SpatieMedia::make($book)
            ->addMediaFromString($contents)
            ->name($book->slug)
            ->extension(Bookshelves::imageFormat())
            ->collection(Bookshelves::imageCollection())
            ->disk(Bookshelves::imageDisk())
            ->color()
            ->save();

        File::delete($temp_path);

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
