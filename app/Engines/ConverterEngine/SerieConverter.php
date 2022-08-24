<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ConverterEngine;
use App\Engines\ParserEngine;
use App\Enums\MediaDiskEnum;
use App\Models\Book;
use App\Models\Serie;
use App\Services\MediaService;
use File;

class SerieConverter
{
    public const DISK = MediaDiskEnum::cover;

    /**
     * Generate Serie for Book from ParserEngine.
     */
    public static function create(ConverterEngine $converter): Serie|false
    {
        if ($converter->parser->serie && ! $converter->book->serie) {
            $serie = Serie::whereSlug($converter->parser->serie_slug)->first();
            if (! $serie) {
                $serie = Serie::firstOrCreate([
                    'title' => $converter->parser->serie,
                    'slug_sort' => $converter->parser->serie_sort,
                    'slug' => $converter->parser->serie_slug_lang,
                    'type' => $converter->parser->type,
                ]);
                $serie->language()->associate($converter->book->language);
                $serie->save();
            }

            $authors_serie = [];
            foreach ($serie->authors as $key => $author) {
                array_push($authors_serie, $author->slug);
            }
            $book_authors = $converter->book->authors;
            foreach ($book_authors as $key => $author) {
                if (! in_array($author->slug, $authors_serie)) {
                    $serie->authors()->save($author);
                }
            }

            $converter->book->serie()->associate($serie);
            $converter->book->save();

            return $serie;
        }

        return false;
    }

    /**
     * Set default cover from first `Book` of `Serie`.
     * Get `volume` `1` if exist.
     */
    public static function setBookCover(Serie $serie): Serie
    {
        $disk = self::DISK;

        if ($serie->getMedia($disk->value)->isEmpty()) {
            $book = Book::whereVolume(1)->whereSerieId($serie->id)->first();
            if (! $book) {
                $book = Book::whereSerieId($serie->id)->first();
            }

            /** @var Book $book */
            $cover_exist = File::exists($book->cover_book?->getPath());
            if ($cover_exist) {
                $cover = base64_encode(File::get($book->cover_book->getPath()));
                MediaService::create($serie, $serie->slug, $disk)
                    ->setMedia($cover)
                    ->setColor()
                ;
            }

            $serie->save();
        }

        return $serie;
    }
}
