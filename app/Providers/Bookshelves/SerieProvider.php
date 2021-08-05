<?php

namespace App\Providers\Bookshelves;

use File;
use Storage;
use App\Models\Book;
use App\Models\Serie;
use App\Utils\BookshelvesTools;
use App\Providers\ImageProvider;

class SerieProvider
{
    public static function setLocalDescription(Serie $serie): ?Serie
    {
        if (File::exists(public_path('storage/raw/series.json'))) {
            $json = Storage::disk('public')->get('raw/series.json');
            $json = json_decode($json);
            foreach ($json as $key => $value) {
                if ($key === $serie->slug) {
                    $serie->description = $value->description;
                    $serie->link = $value->link;
                    $serie->save();

                    return $serie;
                }
            }

            return null;
        }

        return null;
    }

    /**
     * Generate Serie description from Wikipedia if found.
     */
    public static function setDescription(Serie $serie): Serie
    {
        $name = $serie->title;
        $lang = $serie->language->slug;
        $name = str_replace(' ', '%20', $name);
        $name = strtolower($name);

        $wiki = WikipediaProvider::create($name, $lang);

        $extract = BookshelvesTools::stringLimit($wiki->extract, 1000);
        $serie->description = $extract;
        $serie->link = $wiki->page_url;
        $serie->save();

        return $serie;
    }

    /**
     * Generate Serie image from 'public/storage/raw/pictures-series' if JPG file with Serie slug exist
     * if not get image from Book with 'book_number' like '1'.
     *
     * Manage by spatie/laravel-medialibrary.
     */
    public static function setCover(Serie $serie): Serie
    {
        if ($serie->getMedia('series')->isEmpty()) {
            // Add special cover if exist from `public/storage/raw/pictures-series/`
            // Check if JPG file with series' slug name exist
            // To know slug name, check into database when serie was created
            $disk = 'series';
            $custom_series_path = public_path("storage/raw/pictures-$disk/$serie->slug.jpg");

            if (File::exists($custom_series_path)) {
                $file_path = File::get($custom_series_path);
                $serie->addMediaFromString($file_path)
                    ->setName($serie->slug)
                    ->setFileName($serie->slug.'.'.config('bookshelves.cover_extension'))
                    ->toMediaCollection($disk, $disk);
            } else {
                $bookIfExist = Book::whereVolume(1)->whereSerieId($serie->id)->first();
                if (! $bookIfExist) {
                    $bookIfExist = Book::whereSerieId($serie->id)->first();
                }
                if ($bookIfExist) {
                    $book = $bookIfExist;
                    $file_path_exist = File::exists($book->getMedia('books')->first()?->getPath());
                    if ($file_path_exist) {
                        $file_path = File::get($book->getMedia('books')->first()->getPath());
                        $serie->addMediaFromString($file_path)
                            ->setName($serie->slug)
                            ->setFileName($serie->slug.'.'.config('bookshelves.cover_extension'))
                            ->toMediaCollection($disk, $disk);
                    }
                }
                // TODO
                // Setup Logs
                // "$serie->title book not found"
            }

            $serie = $serie->refresh();

            // Get color
            $image = $serie->getFirstMediaPath('series');
            if ($image) {
                $color = ImageProvider::simple_color_thief($image);
                $media = $serie->getFirstMedia('series');
                $media->setCustomProperty('color', $color);
                $media->save();
            }

            return $serie;
        }

        return $serie;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    public static function setTags(Serie $serie): Serie
    {
        $books = Book::whereSerieId($serie->id)->get();
        $tags = [];
        foreach ($books as $key => $book) {
            foreach ($book->tags as $key => $tag) {
                array_push($tags, $tag);
            }
        }

        $serie->syncTags($tags);
        $serie->save();

        return $serie;
    }
}
