<?php

namespace App;

use App\Facades\OpdsSetup as FacadesOpdsSetup;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Closure;
use Illuminate\Support\Facades\Cache;
use Kiwilan\Opds\Entries\OpdsEntryBook;
use Kiwilan\Opds\Entries\OpdsEntryBookAuthor;
use Kiwilan\Opds\Entries\OpdsEntryNavigation;
use Kiwilan\Opds\Opds;
use Kiwilan\Opds\OpdsConfig;

class OpdsSetup
{
    public function app(): Opds
    {
        return Opds::make(FacadesOpdsSetup::config());
    }

    public function config(): OpdsConfig
    {
        $updated = Book::query()->orderBy('updated_at', 'desc')->first()?->updated_at;

        return new OpdsConfig(
            name: config('app.name'),
            author: config('app.name'),
            authorUrl: config('app.url'),
            iconUrl: asset('favicon.ico'),
            startUrl: route('opds.index'),
            searchUrl: route('opds.search'),
            updated: $updated ?: now(),
            forceExit: true,
        );
    }

    /**
     * @return array<OpdsEntryNavigation>
     */
    public function home(): array
    {
        return [
            new OpdsEntryNavigation(
                id: 'latest',
                title: 'Latest books',
                route: route('opds.latest'),
                summary: 'Latest books available',
                updated: Book::query()->orderBy('updated_at', 'desc')->first()?->updated_at,
            ),
            new OpdsEntryNavigation(
                id: 'authors',
                title: 'Authors',
                route: route('opds.authors.index'),
                summary: 'Authors in the library',
                updated: Author::query()->orderBy('updated_at', 'desc')->first()?->updated_at,
            ),
            new OpdsEntryNavigation(
                id: 'series',
                title: 'Series',
                route: route('opds.series.index'),
                summary: 'Series in the library',
                updated: Serie::query()->orderBy('updated_at', 'desc')->first()?->updated_at,
            ),
            new OpdsEntryNavigation(
                id: 'random',
                title: 'Random book',
                route: route('opds.random'),
                summary: 'Random book in the library',
                updated: Book::query()->orderBy('updated_at', 'desc')->first()?->updated_at,
            ),
        ];
    }

    public function cache(string $name, Closure $closure): mixed
    {
        if (config('app.env') === 'local') {
            Cache::forget($name);
        }

        $cache = 60 * 60 * 24;

        return Cache::remember($name, $cache, $closure);
    }

    public function bookToEntry(Book $book): OpdsEntryBook
    {
        $book = $book->load('tags', 'publisher', 'serie', 'authors', 'language', 'media');
        $series = null;
        $seriesContent = null;
        $language = null;

        if ($book->serie) {
            $seriesTitle = $book->serie->title;

            $series = " ({$seriesTitle} vol. {$book->volume})";
            $seriesContent = <<<HTML
                <strong>Series {$seriesTitle} vol.{$book->volume}</strong><br>
            HTML;
        }

        if ($book->language) {
            $language = " in {$book->language->name}";
        }

        $summary = <<<HTML
            $seriesContent $book->description
        HTML;

        $authors = [];

        foreach ($book->authors as $author) {
            $authors[] = new OpdsEntryBookAuthor(
                name: $author->name,
                uri: route('opds.authors.show', ['character' => $author->meta_first_char, 'author' => $author->slug]),
            );
        }

        return new OpdsEntryBook(
            id: $book->slug,
            title: "{$book->title}{$series}{$language}",
            summary: trim($summary),
            content: trim($summary),
            route: route('opds.books.show', ['book' => $book->slug]),
            updated: $book->updated_at,
            download: route('api.download.book', ['book' => $book->id]),
            media: $book->cover_opds,
            mediaThumbnail: $book->cover_opds,
            categories: $book->tags->pluck('name')->toArray(),
            authors: $authors,
            published: $book->released_on,
            volume: $book->volume,
            serie: $book->serie?->title,
            language: $book->language?->name,
            isbn: $book->isbn,
            publisher: $book->publisher?->name,
        );
    }
}
