<?php

namespace App\Engines\Book\Converter\Modules;

use App\Jobs\Serie\SerieJob;
use App\Models\Book;
use App\Models\Serie;
use Kiwilan\Ebook\Ebook;

class SerieModule
{
    public static function make(Ebook $ebook, Book $book): ?Serie
    {
        if (! $ebook->getSeries()) {
            return null;
        }

        $book->loadMissing(['library', 'language', 'authors', 'authorMain']);

        $serie = Serie::query()
            ->where('slug', $ebook->getMetaTitle()->getSeriesSlug())
            ->where('library_id', $book->library?->id)
            ->first();

        if ($serie) {
            if ($book->authors->isNotEmpty()) {
                $serie->authors()->sync($book->authors->pluck('id'));
            }

            return $serie;
        }

        $serie = new Serie([
            'title' => $ebook->getSeries(),
            'slug' => $ebook->getMetaTitle()->getSeriesSlug(),
        ]);
        $serie->saveNoSearch();

        if ($book->library) {
            $serie->library()->associate($book->library);
        }
        if ($book->language) {
            $serie->language()->associate($book->language);
        }
        if ($book->authorMain) {
            $serie->authorMain()->associate($book->authorMain);
        }
        if ($book->authors->isNotEmpty()) {
            $serie->authors()->sync($book->authors->pluck('id'));
        }
        $serie->saveNoSearch();

        SerieJob::dispatch($serie);

        return $serie;
    }
}
