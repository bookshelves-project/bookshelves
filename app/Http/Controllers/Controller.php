<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Library;
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

    public function getBooks(string $column, bool $desc = false, int $limit = 20, ?Library $library = null)
    {
        $books = Book::with([
            'authors',
            'serie',
            'media',
            'language',
            'library',
        ]);

        if ($library) {
            $books->where('library_id', $library->id);
        }

        return $books
            ->orderBy($column, $desc ? 'desc' : 'asc')
            ->limit($limit)
            ->get();
    }
}
