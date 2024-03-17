<?php

namespace App\Http\Controllers;

use App\Enums\BookTypeEnum;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Kiwilan\Steward\Queries\HttpQuery;

abstract class Controller
{
    // public function __construct()
    // {
    //     Route::bind('book_id', fn (string $id) => \App\Models\Book::query()->find($id));
    //     Route::bind('serie_id', fn (string $id) => \App\Models\Serie::query()->find($id));
    //     Route::bind('book_slug', fn (string $slug) => \App\Models\Book::query()->where('slug', $slug)->firstOrFail());
    //     Route::bind('author_slug', fn (string $slug) => \App\Models\Author::query()->where('slug', $slug)->firstOrFail());
    //     Route::bind('serie_slug', fn (string $slug) => \App\Models\Serie::query()->where('slug', $slug)->firstOrFail());
    //     Route::bind('tag_slug', fn (string $slug) => \App\Models\Tag::query()->where('slug', $slug)->firstOrFail());
    // }

    public function getQueryForBooks(Request $request, Builder $model, string $title = 'Books', array $breadcrumbs = [], bool $squareCovers = false)
    {
        $query = HttpQuery::for($model, $request)
            ->with(['authors', 'serie', 'tags', 'media', 'language'])
            ->defaultSort('slug')
            ->inertia();

        return inertia('Books/Index', [
            'title' => $title,
            'query' => $query,
            'breadcrumbs' => $breadcrumbs,
            'square' => $squareCovers,
        ]);
    }

    public function getQueryForSeries(Request $request, Builder $model, string $title = 'Series', array $breadcrumbs = [], bool $squareCovers = false)
    {
        $query = HttpQuery::for($model, $request)
            ->with([
                'authors',
                'tags',
                'media',
                'language',
            ])
            ->withCount(['books'])
            ->defaultSort('slug')
            ->inertia();

        return inertia('Series/Index', [
            'title' => $title,
            'query' => $query,
            'breadcrumbs' => $breadcrumbs,
            'square' => $squareCovers,
        ]);
    }

    public function getSerie(Serie $serie, bool $square = false)
    {
        $serie->load([
            'authors',
            'books',
            'tags',
            'media',
            'books.media',
            'books.language',
            'books.serie',
            'language',
        ])
            ->loadCount('books');

        return inertia('Series/Show', [
            'serie' => $serie,
            'square' => $square,
        ]);
    }

    public function getBooks(string $column, bool $desc = false, int $limit = 20)
    {
        return Book::with([
            'authors',
            'serie',
            'media',
            'language',
        ])
            ->orderBy($column, $desc ? 'desc' : 'asc')
            ->limit($limit)
            ->get();
    }

    public function loadBook(Book $book)
    {
        $book->load([
            'authors',
            'serie',
            'serie.books',
            'serie.books.serie',
            'serie.books.media',
            'tags',
            'media',
            'publisher',
            'language',
        ]);

        $title = $book->title;
        if ($book->serie) {
            $title = "{$book->serie->title} {$book->volume_pad} - {$title} by {$book->authors->implode('name', ', ')}";
        } else {
            $title = "{$title} by {$book->authors->implode('name', ', ')}";
        }

        return inertia('Books/Show', [
            'book' => $book,
            'square' => $book->type === BookTypeEnum::audiobook,
        ]);
    }
}
