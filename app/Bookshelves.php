<?php

namespace App;

class Bookshelves
{
    public function superAdminEmail(): string
    {
        return config('bookshelves.super_admin.email');
    }

    public function superAdminPassword(): string
    {
        return config('bookshelves.super_admin.password');
    }

    public function apiGoogleBooks(): bool
    {
        return config('bookshelves.api.google_books', false);
    }

    public function apiOpenLibrary(): bool
    {
        return config('bookshelves.api.open_library', false);
    }

    public function apiComicVine(): bool
    {
        return config('bookshelves.api.comic_vine', false);
    }

    public function apiIsbn(): bool
    {
        return config('bookshelves.api.isbn', false);
    }

    public function apiWikipedia(): bool
    {
        return config('bookshelves.api.wikipedia', false);
    }

    public function appVersion(): string
    {
        $cache = 'app-version';
        if (cache()->has($cache)) {
            return cache($cache);
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $appVersion = $composer['version'] ?? '0.0.0';
        cache()->put($cache, $appVersion);

        return $appVersion;
    }

    public function analyzerEngine(): string
    {
        return config('bookshelves.analyzer.engine');
    }

    public function analyzerDebug(): bool
    {
        return config('bookshelves.analyzer.debug');
    }

    public function authorWikipediaExact(): bool
    {
        return config('bookshelves.authors.wikipedia_exact');
    }

    /**
     * @return array{books: string|false, comics: string|false, mangas: string|false, audiobooks: string|false}
     */
    public function library(): array
    {
        $library = config('bookshelves.library');

        return [
            'books' => $library['books'],
            'comics' => $library['comics'],
            'mangas' => $library['mangas'],
            'audiobooks' => $library['audiobooks'],
        ];
    }

    public function exceptionParserLog(): string
    {
        $path = storage_path('app/exceptions-parser.json');
        if (! file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        return $path;
    }

    public function convertCovers(): bool
    {
        return config('bookshelves.image.conversion');
    }

    public function imageDisk(): string
    {
        return config('bookshelves.image.disk');
    }

    public function imageCollection(): string
    {
        return config('bookshelves.image.collection');
    }

    public function imageDriver(): string
    {
        return config('bookshelves.image.driver');
    }

    public function imageFormat(): string
    {
        return config('bookshelves.image.format');
    }

    public function imageMaxHeight(): int
    {
        return config('bookshelves.image.max_height');
    }

    public function imageConversion(): bool
    {
        return config('bookshelves.image.conversion');
    }

    /**
     * @return array{width: int, height: int}
     */
    public function imageCoverStandard(): array
    {
        return config('bookshelves.image.cover.standard');
    }

    /**
     * @return array{width: int, height: int}
     */
    public function imageCoverThumbnail(): array
    {
        return config('bookshelves.image.cover.thumbnail');
    }

    /**
     * @return array{width: int, height: int}
     */
    public function imageCoverSocial(): array
    {
        return config('bookshelves.image.cover.social');
    }
}
