<?php

namespace App\Engines;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Closure;
use Illuminate\Support\Facades\Cache;
use Kiwilan\Opds\Entries\OpdsEntry;
use Kiwilan\Opds\Entries\OpdsEntryBook;
use Kiwilan\Opds\Entries\OpdsEntryBookAuthor;
use Kiwilan\Opds\OpdsConfig;

class OpdsApp
{
    public static function config(): OpdsConfig
    {
        return new OpdsConfig(
            name: config('app.name'),
            author: 'Bookshelves',
            authorUrl: config('app.url'),
            iconUrl: asset('favicon.ico'),
            startUrl: route('opds.index'),
            searchUrl: route('opds.search'),
            updated: Book::orderBy('updated_at', 'desc')->first()->updated_at,
        );
    }

    /**
     * @return array<OpdsEntry>
     */
    public static function home(): array
    {
        $authors = self::cache('opds.authors', fn () => Author::all());
        $series = self::cache('opds.series', fn () => Serie::all());

        return [
            new OpdsEntry(
                id: 'latest',
                title: 'Latest',
                route: route('opds.latest'),
                summary: 'Latest books',
                media: asset('vendor/images/opds/books.png'),
                updated: Book::orderBy('updated_at', 'desc')->first()->updated_at,
            ),
            new OpdsEntry(
                id: 'authors',
                title: 'Authors',
                route: route('opds.authors.index'),
                summary: "Authors, {$authors->count()} available",
                media: asset('vendor/images/opds/authors.png'),
                updated: Author::orderBy('updated_at', 'desc')->first()->updated_at,
            ),
            new OpdsEntry(
                id: 'series',
                title: 'Series',
                route: route('opds.series.index'),
                summary: "Series, {$series->count()} available",
                media: asset('vendor/images/opds/series.png'),
                updated: Serie::orderBy('updated_at', 'desc')->first()->updated_at,
            ),
            new OpdsEntry(
                id: 'random',
                title: 'Random',
                route: route('opds.random'),
                summary: 'Random books',
                media: asset('vendor/images/opds/books.png'),
                updated: Book::orderBy('updated_at', 'desc')->first()->updated_at,
            ),
        ];
    }

    public static function cache(string $name, Closure $closure): mixed
    {
        if (config('app.env') === 'local') {
            Cache::forget($name);
        }

        $cache = 60 * 60 * 24;

        return Cache::remember($name, $cache, $closure);
    }

    public static function bookToEntry(Book $book): OpdsEntryBook
    {
        $book = $book->load('authors', 'serie', 'tags');
        $series = null;
        $seriesContent = null;

        if ($book->serie) {
            $seriesTitle = $book->serie->title;

            $series = " ({$seriesTitle} vol. {$book->volume})";
            $seriesContent = <<<HTML
                <strong>Series {$seriesTitle} vol.{$book->volume}</strong><br>
            HTML;
        }

        $summary = <<<HTML
            $seriesContent $book->description
        HTML;

        $authors = [];

        foreach ($book->authors as $author) {
            $authors[] = new OpdsEntryBookAuthor(
                name: $author->name,
                uri: route('opds.authors.show', ['author' => $author->slug]),
            );
        }

        return new OpdsEntryBook(
            id: $book->slug,
            title: "{$book->title}{$series}",
            summary: $summary,
            content: $summary,
            route: route('opds.books.show', ['author' => $book->meta_author, 'book' => $book->slug]),
            updated: $book->updated_at,
            download: route('api.download.book', ['author_slug' => $book->meta_author, 'book_slug' => $book->slug]),
            media: $book->cover_og,
            mediaThumbnail: $book->cover_thumbnail,
            categories: $book->tags->pluck('name')->toArray(),
            authors: $authors,
            published: $book->released_on,
            volume: $book->volume,
            serie: $book->serie?->title,
            language: $book->language?->name, // @phpstan-ignore-line
        );
    }
}
