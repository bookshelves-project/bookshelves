<?php

namespace App\Engines\Converter\Modules;

use App\Models\Book;
use App\Models\Serie;

class SerieModule
{
    public static function make(string $title, string $slug, string|int $library_id): ?Serie
    {
        $serie = new Serie([
            'title' => $title,
            'slug' => $slug,
        ]);
        $serie->saveNoSearch();

        $serie->library()->associate($library_id);
        $serie->saveNoSearch();

        return $serie;
    }

    public static function associate(Serie $serie, Book $book): ?Serie
    {
        if (! $book->has_series) {
            return null;
        }

        $book->serie()->associate($serie);
        $book->saveNoSearch();

        $book->loadMissing(['library', 'language', 'authors', 'authorMain']);

        if ($book->authors->isNotEmpty()) {
            $serie->authors()->syncWithoutDetaching($book->authors->pluck('id'));
        }

        if ($book->is_audiobook) {
            $book->is_audiobook = true;
        }
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

        return $serie;
    }
}
