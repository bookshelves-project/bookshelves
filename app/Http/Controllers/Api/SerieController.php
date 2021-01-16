<?php

namespace App\Http\Controllers\Api;

use App\Models\Serie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SerieResource;
use App\Http\Resources\SerieCollection;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage');

        $series = Serie::with('books');
        if (null !== $perPage) {
            $series = $series->paginate($perPage);
        } else {
            $series = $series->get();
        }

        $series = SerieCollection::collection($series);

        return $series;
    }

    public function count()
    {
        return Serie::count();
    }

    public function show(Request $request, string $serie)
    {
        $serie = Serie::whereSlug($serie)->firstOrFail();
        $serie = SerieResource::make($serie);

        return $serie;
    }
}
