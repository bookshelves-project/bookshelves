<?php

namespace App\Services\ConverterEngine;

use App\Models\Book;
use App\Models\Serie;
use App\Services\ParserEngine\ParserEngine;
use App\Services\WikipediaService\WikipediaQuery;
use App\Utils\BookshelvesTools;
use App\Utils\MediaTools;
use File;
use Storage;

class SerieConverter
{
    public const DISK = 'series';

    /**
     * Generate Serie for Book from ParserEngine.
     */
    public static function create(ParserEngine $parser, Book $book): Serie|false
    {
        if ($parser->serie) {
            $serie = Serie::whereSlug($parser->serie_slug)->first();
            if (! $serie) {
                $serie = Serie::firstOrCreate([
                    'title' => $parser->serie,
                    'title_sort' => $parser->serie_sort,
                    'slug' => $parser->serie_slug_lang,
                ]);
                $serie->language()->associate($parser->language);
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
    public static function setWikiDescription(Serie $serie, WikipediaQuery $query): Serie
    {
        $serie->description = BookshelvesTools::stringLimit($query->extract, 1000);
        $serie->link = $query->page_url;
        $serie->save();

        return $serie;
    }

    /**
     * Generate Serie image from 'public/storage/data/pictures-series' if JPG file with Serie slug exist
     * if not get image from Book with 'book_number' like '1'.
     *
     * Manage by spatie/laravel-medialibrary.
     */
    public static function getLocalCover(Serie $serie): string|null
    {
        $disk = self::DISK;
        // Add special cover if exist from `public/storage/data/pictures-series/`
        // Check if JPG file with series' slug name exist
        // To know slug name, check into database when serie was created
        $path = public_path("storage/data/pictures-{$disk}");
        $files = BookshelvesTools::getDirectoryFiles($path);

        $local_cover = null;
        foreach ($files as $key => $file) {
            if (pathinfo($file)['filename'] === $serie->slug) {
                $local_cover = base64_encode(file_get_contents($file));
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
            $disk = self::DISK;

            // get picture in $path if exist
            $cover = null;
            $local_cover = self::getLocalCover($serie);
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
                    $cover = base64_encode(File::get($book->getMedia('books')->first()->getPath()));
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
