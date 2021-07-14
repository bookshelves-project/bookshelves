<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Models\Serie;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Serie\SerieResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Search\SearchSerieResource;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::with(['authors', 'media'])->orderBy('title_sort')->get();

        $series = SearchSerieResource::collection($series);
        $series = collect($series);

        return view('pages.api.catalog.series.index', compact('series'));
    }

    public function show(Request $request, string $author, string $slug)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($slug)->firstOrFail();

        $books = BookLightResource::collection($serie->books);
        $books = json_decode($books->toJson());

        $serie = SerieResource::make($serie);
        $serie = json_decode($serie->toJson());

        return view('pages.api.catalog.series._slug', compact('serie', 'books'));
    }
}
