<?php

namespace App\Providers\BookshelvesConverterEngine;

use File;
use Storage;
use App\Models\Book;
use App\Models\Serie;
use App\Utils\MediaTools;
use App\Utils\BookshelvesTools;
use App\Providers\WikipediaProvider;
use App\Providers\EbookParserEngine\EbookParserEngine;

class SerieConverter
{
    /**
     * Generate Serie for Book from EbookParserEngine.
     */
    public static function create(EbookParserEngine $epe, Book $book): Serie|false
    {
        if ($epe->serie) {
            $serie = Serie::whereSlug($epe->serie_slug)->first();
            if (! $serie) {
                $serie = Serie::firstOrCreate([
                    'title'      => $epe->serie,
                    'title_sort' => $epe->serie_sort,
                    'slug'       => $epe->serie_slug_lang,
                ]);
                $serie->language()->associate($epe->language);
                $serie->save();
            }

            $authors_serie = [];
            foreach ($serie->authors as $key => $author) {
                array_push($authors_serie, $author->slug);
            }
            $book_authors = $book->authors;
            foreach ($book_authors as $key => $author) {
                if (! in_array($author->slug, $authors_serie)) {
                    $serie->authors()->save($author);
                }
            }

            $book->serie()->associate($serie);
            $book->save();

            return $serie;
        }

        return false;
    }

    // public static function setLocalDescription(Serie $serie): ?Serie
    // {
    //     if (File::exists(public_path('storage/data/series.json'))) {
    //         $json = Storage::disk('public')->get('raw/series.json');
    //         $json = json_decode($json);
    //         foreach ($json as $key => $value) {
    //             if ($key === $serie->slug) {
    //                 $serie->description = $value->description;
    //                 $serie->link = $value->link;
    //                 $serie->save();

    //                 return $serie;
    //             }
    //         }

    //         return null;
    //     }

    //     return null;
    // }

    /**
     * Generate Serie description from Wikipedia if found.
     */
    public static function setWikiDescription(Serie $serie, WikipediaProvider $wiki): Serie
    {
        $serie->description = BookshelvesTools::stringLimit($wiki->extract, 1000);
        $serie->link = $wiki->page_url;
        $serie->save();

        return $serie;
    }

    /**
     * Generate Serie image from 'public/storage/data/pictures-series' if JPG file with Serie slug exist
     * if not get image from Book with 'book_number' like '1'.
     *
     * Manage by spatie/laravel-medialibrary.
     */
    public static function getLocalCover(Serie $serie, string $disk): String|null
    {
        // Add special cover if exist from `public/storage/data/pictures-series/`
        // Check if JPG file with series' slug name exist
        // To know slug name, check into database when serie was created
        $path = public_path("storage/data/pictures-$disk");
        $files = BookshelvesTools::getDirectoryFiles($path);

        $local_cover = null;
        foreach ($files as $key => $file) {
            if (pathinfo($file)['filename'] === $serie->slug) {
                $local_cover = file_get_contents($file);
            }
        }
        
        return $local_cover;
    }

    /**
     * Generate Serie image from Book volume '1' or first.
     *
     * Manage by spatie/laravel-medialibrary.
     */
    public static function setCover(Serie $serie): Serie
    {
        if ($serie->getMedia('series')->isEmpty()) {
            $disk = 'series';

            // get picture in $path if exist
            $local_cover = self::getLocalCover($serie, $disk);
            if ($local_cover) {
                $cover = $local_cover;
            } else {
                // get first book of serie
                $book = Book::whereVolume(1)->whereSerieId($serie->id)->first();
                if (! $book) {
                    $book = Book::whereSerieId($serie->id)->first();
                }
                $cover_exist = File::exists($book->getMedia('books')->first()?->getPath());
                if ($cover_exist) {
                    $cover = File::get($book->getMedia('books')->first()->getPath());
                }
            }
            if ($cover) {
                $media = new MediaTools($serie, $serie->slug, $disk);
                $media->setMedia($cover);
                $media->setColor();
            }
            $serie->refresh();

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
