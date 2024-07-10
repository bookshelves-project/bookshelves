<?php

namespace App\Engines\Book;

use App\Models\AudiobookTrack;
use App\Models\Language;
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

    public static function audiobookParseTitle(?string $title): ?string
    {
        if (! $title) {
            return null;
        }

        if (! str_contains($title, '#') && ! str_contains($title, ':')) {
            return $title;
        }

        // `La Quête d'Ewilan #01 : D'un monde à l'autre`
        // to `D'un monde à l'autre`
        if (preg_match('/#\d+ : (.*)/', $title, $matches)) {
            $result = $matches[1] ?? null;
            if ($result) {
                return trim($result);
            }
        }

        return $title;
    }

    public static function audiobookParseLang(?string $book_lang, ?string $book_comment): ?string
    {
        if (! $book_lang && ! $book_comment) {
            return null;
        }

        $lang = $book_lang ?? $book_comment;
        $lang_code = self::toIsoCode($lang);

        foreach (Language::all() as $language) {
            if ($lang_code === $language->slug) {
                return $language->slug;
            }

            if (strtolower($lang) === strtolower($language->name)) {
                return $language->slug;
            }
        }

        return $lang_code;
    }

    private static function toIsoCode(?string $lang): ?string
    {
        if (! $lang) {
            return null;
        }

        $lang = strtolower($lang);

        $codes = [
            'english' => 'en',
            'french' => 'fr',
            'spanish' => 'es',
            'german' => 'de',
            'italian' => 'it',
            'portuguese' => 'pt',
            'russian' => 'ru',
            'japanese' => 'ja',
            'chinese' => 'zh',
            'korean' => 'ko',
            'arabic' => 'ar',
            'turkish' => 'tr',
            'dutch' => 'nl',
            'polish' => 'pl',
            'swedish' => 'sv',
            'danish' => 'da',
            'norwegian' => 'no',
            'finnish' => 'fi',
            'czech' => 'cs',
            'hungarian' => 'hu',
            'greek' => 'el',
            'hebrew' => 'he',
            'hindi' => 'hi',
            'indonesian' => 'id',
            'malay' => 'ms',
            'thai' => 'th',
            'vietnamese' => 'vi',
            'bulgarian' => 'bg',
            'croatian' => 'hr',
            'estonian' => 'et',
            'latvian' => 'lv',
            'lithuanian' => 'lt',
            'romanian' => 'ro',
            'slovak' => 'sk',
            'slovenian' => 'sl',
            'ukrainian' => 'uk',
            'catalan' => 'ca',
            'filipino' => 'fil',
            'serbian' => 'sr',
            'icelandic' => 'is',
            'maltese' => 'mt',
            'persian' => 'fa',
            'swahili' => 'sw',
            'afrikaans' => 'af',
            'albanian' => 'sq',
            'amharic' => 'am',
            'armenian' => 'hy',
            'azerbaijani' => 'az',
            'basque' => 'eu',
            'belarusian' => 'be',
            'bengali' => 'bn',
        ];

        if (array_key_exists($lang, $codes)) {
            return $codes[$lang];
        }

        return null;
    }
}
