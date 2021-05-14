<?php

namespace App\Providers\Bookshelves;

use File;
use Http;
use App\Models\Book;
use App\Models\Serie;
use App\Utils\BookshelvesTools;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class SerieProvider
{
    /**
     * Generate Serie description from Wikipedia if found.
     *
     * @param Serie $serie
     *
     * @return Serie
     */
    public static function description(Serie $serie): Serie
    {
        $name = $serie->title;
        $lang = $serie->language->slug;
        $name = str_replace(' ', '%20', $name);
        $name = strtolower($name);
        $url = "https://$lang.wikipedia.org/w/api.php?action=query&list=search&srsearch=$name&format=json";
        $pageId = null;
        try {
            $response = Http::get($url);
            $response = $response->json();
            $search = $response['query']['search'];
            if (array_key_exists(0, $search)) {
                $pageId = $search[0]['pageid'];
            }
        } catch (\Throwable $th) {
        }
        if ($pageId) {
            $url = "http://$lang.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts&inprop=url";
            $desc = null;
            try {
                $response = Http::get($url);
                $response = $response->json();
                $desc = $response['query']['pages'];
                $desc = reset($desc);
                $url = $desc['fullurl'];
                $desc = $desc['extract'];
                $desc = BookshelvesTools::stringLimit($desc, 500);
            } catch (\Throwable $th) {
            }
            if (is_string($desc)) {
                $serie->description = $desc;
                $serie->wikipedia_link = $url;
                $serie->save();
            }
        }

        return $serie;
    }

    /**
     * Generate Serie image from 'public/storage/raw/covers-series' if JPG file with Serie slug exist
     * if not get image from Book with 'book_number' like '1'.
     *
     * Manage by spatie/laravel-medialibrary.
     *
     * @param Serie $serie
     *
     * @return Serie
     */
    public static function cover(Serie $serie): Serie
    {
        if ($serie->getMedia('series')->isEmpty()) {
            // Add special cover if exist from `database/seeders/medias/series/`
            // Check if JPG file with series' slug name exist
            // To know slug name, check into database when serie was created
            $disk = 'series';
            $custom_series_path = public_path("storage/raw/covers-$disk/$serie->slug.jpg");

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
            $color = MetadataExtractorTools::simple_color_thief($image);
            $media = $serie->getFirstMedia('series');
            $media->setCustomProperty('color', $color);
            $media->save();

            return $serie;
        }

        return $serie;
    }

    /**
     * Generate Language relationship for Serie from first Book of Serie.
     *
     * @param Serie $serie
     *
     * @return Serie
     */
    public static function language(Serie $serie): Serie
    {
        if (! $serie->language) {
            $bookSelected = $serie->books[0];
            foreach ($serie->books as $key => $book) {
                if (1 === $book->volume) {
                    $bookSelected = $book;
                } else {
                    $bookSelected = $book;
                }
            }
            if ($bookSelected->language) {
                $serie->language()->associate($bookSelected->language);
                $serie->save();
            }

            return $serie;
        }

        return $serie;
    }
}
