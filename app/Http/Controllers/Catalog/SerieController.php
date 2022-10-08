<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Http\Request;
use Kiwilan\Steward\Utils\Toolbox;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('series')]
class SerieController extends Controller
{
    #[Get('/', name: 'series')]
    public function index(Request $request)
    {
        $series = Serie::with(['authors', 'media'])->get();
        $series = Toolbox::chunkByAlpha($series, 'title');

        return view('catalog::pages.series.index', compact('series'));
    }

    #[Get('/{character}', name: 'series.character')]
    public function character(Request $request)
    {
        $character = $request->character;
        $series = Serie::with(['authors', 'media'])->get();

        $chunks = Toolbox::chunkByAlpha($series, 'title');
        $current_chunk = [];
        $series = $chunks->first(function ($value, $key) use ($character) {
            return $key === strtoupper($character);
        });

        $series = EntityResource::collection($series);

        return view('catalog::pages.series.characters', compact('series', 'character'));
    }

    #[Get('/{author}/{serie}', name: 'series.show')]
    public function show(Request $request, string $author, string $slug)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereRelation('authors', fn ($query) => $query->where('author_id', '=', $author->id))
            ->whereSlug($slug)
            ->firstOrFail()
        ;

        $books = EntityResource::collection($serie->books->where('is_disabled', false));

        $serie = SerieResource::make($serie);
        $serie = json_decode($serie->toJson());

        return view('catalog::pages.series._slug', compact('serie', 'books'));
    }
}
