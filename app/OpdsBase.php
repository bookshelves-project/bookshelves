<?php

namespace App;

use App\Facades\OpdsBase as FacadesOpdsBase;
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

class OpdsBase
{
    public function app(): Opds
    {
        return Opds::make(FacadesOpdsBase::config());
    }

    public function config(): OpdsConfig
    {
        return new OpdsConfig(
            name: config('app.name'),
            author: config('app.name'),
            authorUrl: config('app.url'),
            iconUrl: asset('favicon.ico'),
            startUrl: route('opds.index'),
            searchUrl: route('opds.search'),
            updated: Book::query()->orderBy('updated_at', 'desc')->first()->updated_at,
        );
    }

    /**
     * @return array<OpdsEntryNavigation>
     */
    public function home(): array
    {
        $authorsCount = Author::query()->count();
        $seriesCount = Serie::query()->count();

        return [
            new OpdsEntryNavigation(
                id: 'latest',
                title: 'Latest',
                route: route('opds.latest'),
                summary: 'Latest books',
                media: asset('vendor/images/opds/books.png'),
                updated: Book::query()->orderBy('updated_at', 'desc')->first()->updated_at,
            ),
            new OpdsEntryNavigation(
                id: 'authors',
                title: 'Authors',
                route: route('opds.authors.index'),
                summary: "Authors, {$authorsCount} available",
                media: asset('vendor/images/opds/authors.png'),
                updated: Author::query()->orderBy('updated_at', 'desc')->first()->updated_at,
            ),
            new OpdsEntryNavigation(
                id: 'series',
                title: 'Series',
                route: route('opds.series.index'),
                summary: "Series, {$seriesCount} available",
                media: asset('vendor/images/opds/series.png'),
                updated: Serie::query()->orderBy('updated_at', 'desc')->first()->updated_at,
            ),
            new OpdsEntryNavigation(
                id: 'random',
                title: 'Random',
                route: route('opds.random'),
                summary: 'Random books',
                media: asset('vendor/images/opds/books.png'),
                updated: Book::query()->orderBy('updated_at', 'desc')->first()->updated_at,
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
        $book = $book->load('tags', 'publisher');
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
                uri: route('opds.authors.show', ['character' => $author->meta_first_char, 'author' => $author->slug]),
            );
        }

        return new OpdsEntryBook(
            id: $book->slug,
            title: "{$book->title}{$series}",
            summary: trim($summary),
            content: trim($summary),
            route: route('opds.books.show', ['book' => $book->slug]),
            updated: $book->updated_at,
            download: route('api.downloads.book', ['book_id' => $book->id]),
            media: $book->cover_social,
            mediaThumbnail: $book->cover_thumbnail,
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
