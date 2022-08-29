<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Serie\SerieCollectionResource;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series')]
class SerieController extends ApiController
{
    #[Get('/', name: 'series.index')]
    public function index()
    {
        $models = Serie::orderBy('slug')
            ->paginate(32)
        ;

        return SerieCollectionResource::collection($models);
    }

    #[Get('/{author_slug}/{serie_slug}', name: 'series.show')]
    public function show(Request $request, Author $author, Serie $serie)
    {
        return new SerieResource($serie);
    }
}
