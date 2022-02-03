<?php

namespace App\Http\Controllers\Front\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Author;
use App\Models\Serie;
use App\Utils\BookshelvesTools;
use Illuminate\Http\Request;

/**
 * @hideFromAPIDocumentation
 */
class SerieController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::with(['authors', 'media'])->get();
        $series = BookshelvesTools::chunkByAlpha($series, 'title');

        return view('front.pages.catalog.series.index', compact('series'));
    }

    public function character(Request $request)
    {
        $character = $request->character;
        $series = Serie::with(['authors', 'media'])->get();

        $chunks = BookshelvesTools::chunkByAlpha($series, 'title');
        $current_chunk = [];
        $series = $chunks->first(function ($value, $key) use ($character) {
            return $key === strtoupper($character);
        });

        $series = EntityResource::collection($series);

        return view('front.pages.catalog.series.character', compact('series', 'character'));
    }

    public function show(Request $request, string $author, string $slug)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($slug)->firstOrFail();

        $books = EntityResource::collection($serie->books);

        $serie = SerieResource::make($serie);
        $serie = json_decode($serie->toJson());

        return view('front.pages.catalog.series._slug', compact('serie', 'books'));
    }
}
