<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Kiwilan\Steward\Queries\HttpQuery;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        Route::bind('book_slug', fn (string $slug) => \App\Models\Book::query()->where('slug', $slug)->firstOrFail());
        Route::bind('author_slug', fn (string $slug) => \App\Models\Author::query()->where('slug', $slug)->firstOrFail());
    }

    public function getQueryForBooks(Request $request, Builder $model, string $title = 'Books', array $breadcrumbs = [], bool $squareCovers = false)
    {
        $query = HttpQuery::for($model, $request)
            ->with(['authors', 'serie', 'tags', 'media'])
            ->defaultSort('slug_sort')
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
            ->with(['authors', 'tags', 'media'])
            ->defaultSort('slug_sort')
            ->inertia();

        return inertia('Series/Index', [
            'title' => $title,
            'query' => $query,
            'breadcrumbs' => $breadcrumbs,
            'square' => $squareCovers,
        ]);
    }
}
