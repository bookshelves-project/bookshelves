<?php

namespace App\Providers\Bookshelves;

use File;
use Http;
use Storage;
use App\Models\Book;
use App\Models\Serie;
use App\Utils\BookshelvesTools;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class SerieProvider
{
    public static function localDescription(Serie $serie): ?Serie
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
                $serie->description = "$desc";
                $serie->link = $url;
                $serie->save();
            }
        }

        return $serie;
    }

    /**
     * Generate Serie image from 'public/storage/raw/pictures-series' if JPG file with Serie slug exist
     * if not get image from Book with 'book_number' like '1'.
     *
     * Manage by spatie/laravel-medialibrary.
     */
    public static function cover(Serie $serie): Serie
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
            $color = MetadataExtractorTools::simple_color_thief($image);
            $media = $serie->getFirstMedia('series');
            $media->setCustomProperty('color', $color);
            $media->save();

            return $serie;
        }

        return $serie;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    public static function tags(Serie $serie): Serie
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
