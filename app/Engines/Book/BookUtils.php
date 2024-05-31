<?php

namespace App\Engines\Book;

use App\Models\AudiobookTrack;
use Illuminate\Support\Collection;

class BookUtils
{
    /**
     * Select the most used language in the author books.
     *
     * @param  Collection<int, \App\Models\Book>  $books
     */
    public static function selectLang(Collection $books): string
    {
        $languages = [];
        foreach ($books as $book) {
            $book->load('language');
            if (! $book->language) {
                continue;
            }
            if (array_key_exists($book->language->slug, $languages)) {
                $languages[$book->language->slug]++;
            } else {
                $languages[$book->language->slug] = 1;
            }
        }

        $lang = 'en';
        if (count($languages) > 0) {
            $lang = array_search(max($languages), $languages);
        }

        return $lang;
    }

    public static function audiobookTrackCoverPath(AudiobookTrack $track): string
    {
        $name = "audiobook-{$track->id}.jpg";

        return storage_path("app/audiobooks/{$name}");
    }
}
