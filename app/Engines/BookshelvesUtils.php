<?php

namespace App\Engines;

use App\Models\AudiobookTrack;
use App\Models\Language;
use Illuminate\Support\Collection;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Services\DirectoryService;

/**
 * Some utility functions for bookshelves.
 */
class BookshelvesUtils
{
    public static function clearCache(): void
    {
        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
        DirectoryService::make()->clearDirectory(storage_path('clockwork'));

        $indexes = [
            'author',
            'book',
            'cover',
            'language',
            'library',
            'publisher',
            'serie',
            'tag',
        ];

        foreach ($indexes as $index) {
            DirectoryService::make()->clearDirectory(storage_path("app/index/{$index}"));
        }
    }

    public static function getIndexPath(string $folder, string|int $filename, ?string $subfolder = null, string $extension = 'dat'): string
    {
        $base = storage_path('app'.DIRECTORY_SEPARATOR.'index'.DIRECTORY_SEPARATOR);
        $base .= $folder.DIRECTORY_SEPARATOR;
        $filename = strval($filename);

        if ($subfolder) {
            $base .= $subfolder.DIRECTORY_SEPARATOR;
        }

        return $base.$filename.'.'.$extension;
    }

    /**
     * Save the contents as a JSON file.
     */
    public static function saveAsJSON(string $json_path, mixed $contents): bool
    {
        self::ensureFileExists($json_path);
        $flags = config('app.debug') ? JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT : JSON_UNESCAPED_SLASHES;

        try {
            return file_put_contents($json_path, json_encode($contents, $flags)) !== false;
        } catch (\Throwable $th) {
            Journal::error("BookshelvesUtils: failed to save index of {$json_path}", [$th->getMessage()]);
        }

        return false;
    }

    /**
     * Load the contents from a JSON file.
     */
    public static function loadFromJSON(string $json_path): mixed
    {
        if (! file_exists($json_path)) {
            return null;
        }

        $contents = file_get_contents($json_path);
        if (! $contents) {
            return null;
        }

        return json_decode($contents, true);
    }

    /**
     * Serialize the contents of a file.
     */
    public static function serialize(string $file_path, mixed $contents): bool
    {
        self::ensureFileExists($file_path);

        try {
            return file_put_contents($file_path, serialize($contents));
        } catch (\Throwable $th) {
            Journal::error("BookshelvesUtils: failed to save index of {$file_path}", [$th->getMessage()]);
        }

        return false;
    }

    /**
     * Unserialize the contents of a file.
     */
    public static function unserialize(string $file_path): mixed
    {
        return unserialize(file_get_contents($file_path));
    }

    /**
     * Ensure that the file exists and is writable (remove it before creating a new one).
     */
    public static function ensureFileExists(string $path, bool $recreate = true): void
    {
        self::ensureDirectoryExists($path);

        if ($recreate && file_exists($path)) {
            unlink($path);
        }
        if (! file_exists($path)) {
            touch($path);
        }
    }

    public static function ensureDirectoryExists(string $path): void
    {
        $dirname = dirname($path);
        if (! is_dir($dirname) && ! file_exists($dirname)) {
            mkdir($dirname, 0755, true);
        }
    }

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
            $result = $matches[1];
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
