<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Library;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class AuthorController extends Controller
{
    #[Get('/authors/{author:slug}/books', name: 'api.authors.books')]
    public function books(Request $request, Author $author)
    {
        return response()->json([
            'data' => $this->getAuthorBooks($request, $author, 'books'),
        ]);
    }

    #[Get('/authors/{author:slug}/series', name: 'api.authors.series')]
    public function series(Request $request, Author $author)
    {
        return response()->json([
            'data' => $this->getAuthorBooks($request, $author, 'series'),
        ]);
    }

    #[Get('/authors/{author:slug}/counts', name: 'api.authors.counts')]
    public function counts(Request $request, Author $author)
    {
        $author->loadCount(['books', 'series']);

        return response()->json([
            'data' => [
                'books' => $author->books_count,
                'series' => $author->series_count,
            ],
        ]);
    }

    private function getAuthorBooks(Request $request, Author $author, string $model): array
    {
        $standalone = $request->boolean('standalone', false);

        if ($model === 'books') {
            $author->loadMissing([
                'books.library',
                'books.media',
                'books.serie',
                'books.language',
            ]);
        } elseif ($model === 'series') {
            $author->loadMissing([
                'series.library',
                'series.media',
                'series.language',
            ]);
        }

        $libraries = collect();
        foreach (Library::all() as $library) {
            $models = [];
            if ($model === 'books') {
                if ($standalone) {
                    $models = $author->books->filter(fn ($book) => $book->library?->slug === $library->slug && $book->serie_id === null);
                } else {
                    $models = $author->books->filter(fn ($book) => $book->library?->slug === $library->slug);
                }
            } elseif ($model === 'series') {
                $models = $author->series->filter(fn ($serie) => $serie->library?->slug === $library->slug);
            }

            $libraries->push([
                'name' => $library->name,
                'models' => $models->values(),
            ]);
        }

        $libraries = $libraries->filter(fn ($library) => $library['models']->isNotEmpty());

        return $libraries->values()->toArray();
    }
}
