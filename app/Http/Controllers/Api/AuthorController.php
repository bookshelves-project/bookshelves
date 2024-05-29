<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Library;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class AuthorController extends Controller
{
    #[Get('/authors/{author:slug}', name: 'api.authors')]
    public function series(Request $request, Author $author)
    {
        $author->loadMissing([
            'books.library',
            'books.media',
            'books.serie',
            'books.language',
            'series.library',
            'series.media',
            'series.language',
        ]);

        $libraries = collect();
        foreach (Library::all() as $library) {
            $books = $author->books->filter(fn ($book) => $book->library->slug === $library->slug);
            $series = $author->series->filter(fn ($serie) => $serie->library->slug === $library->slug);
            $libraries->push([
                'name' => $library->name,
                'books' => $books->values(),
                'series' => $series->values(),
            ]);
        }

        $libraries = $libraries->filter(fn ($library) => $library['books']->isNotEmpty());
        $libraries = $libraries->values()->toArray();

        return response()->json([
            'data' => $libraries,
        ]);
    }
}
