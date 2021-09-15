<?php

namespace App\Providers\BookshelvesConverter;

use File;
use Storage;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Support\Str;
use App\Utils\BookshelvesTools;
use App\Providers\ImageProvider;
use App\Providers\EbookParserEngine\EbookParserEngine;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class SerieConverter
{/**
     * Generate Serie for Book from EbookParserEngine.
     */
    public static function create(EbookParserEngine $EPE, Book $book): Book
    {
        if ($EPE->serie) {
            $serieIfExist = Serie::whereSlug($EPE->serie_slug)->first();
            $serie = null;
            if (! $serieIfExist) {
                $serie = Serie::firstOrCreate([
                    'title'      => $EPE->serie,
                    'title_sort' => $EPE->serie_sort,
                    'slug'       => $EPE->serie_slug_lang,
                ]);
                $serie->language()->associate($EPE->language);
                $serie->save();
            } else {
                $serie = $serieIfExist;
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
        }

        return $book;
    }

    /**
     * Generate full title sort.
     */
    public static function sortTitleWithSerie(Book $book): string
    {
        $serie = null;
        if ($book->serie) {
            $volume = strlen($book->volume) < 2 ? '0' . $book->volume : $book->volume;
            $serie = $book->serie?->title_sort . ' ' . $volume;
            $serie = Str::slug($serie) . '_';
        }
        $title = Str::slug($book->title_sort);

        return "$serie$title";
    }

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

            $path = public_path("storage/raw/pictures-$disk");
            $files = MetadataExtractorTools::getDirectoryFiles($path);

            $cover = null;
            foreach ($files as $key => $file) {
                if (pathinfo($file)['filename'] === $serie->slug) {
                    $cover = file_get_contents($file);
                }
            }

            if ($cover) {
                $serie->addMediaFromString($cover)
                    ->setName($serie->slug)
                    ->setFileName($serie->slug . '.' . config('bookshelves.cover_extension'))
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
                            ->setFileName($serie->slug . '.' . config('bookshelves.cover_extension'))
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
