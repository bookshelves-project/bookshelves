<?php

namespace App\Engines\ConverterEngine\Modules;

use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\Modules\Interface\ConverterInterface;
use App\Engines\ParserEngine;
use App\Enums\MediaDiskEnum;
use App\Models\Book;
use App\Models\Serie;
use File;
use Kiwilan\Steward\Services\MediaService;

class SerieConverter implements ConverterInterface
{
    public const DISK = MediaDiskEnum::cover;

    /**
     * Generate Serie for Book from ParserEngine.
     */
    public static function make(ConverterEngine $converter_engine): Serie|false
    {
        if ($converter_engine->parser_engine->serie && ! $converter_engine->book->serie) {
            $serie = Serie::whereSlug($converter_engine->parser_engine->serie_slug)->first();
            if (! $serie) {
                $serie = Serie::firstOrCreate([
                    'title' => $converter_engine->parser_engine->serie,
                    'slug_sort' => $converter_engine->parser_engine->serie_sort,
                    'slug' => $converter_engine->parser_engine->serie_slug_lang,
                    'type' => $converter_engine->parser_engine->type,
                ]);
                $serie->language()->associate($converter_engine->book->language);
                $serie->save();
            }

            $authors_serie = [];
            foreach ($serie->authors as $key => $author) {
                array_push($authors_serie, $author->slug);
            }
            $book_authors = $converter_engine->book->authors;
            foreach ($book_authors as $key => $author) {
                if (! in_array($author->slug, $authors_serie)) {
                    $serie->authors()->save($author);
                }
            }

            $converter_engine->book->serie()->associate($serie);
            $converter_engine->book->save();

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
                MediaService::make($serie, $serie->slug, $disk)
                    ->setMedia($cover)
                    ->setColor()
                ;
            }

            $serie->save();
        }

        return $serie;
    }
}
