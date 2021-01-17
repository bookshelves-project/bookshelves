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
        $debug = $request->get('debug');

        $series = Serie::with('books')->get();

        $articles = [
            'The',
            'Les',
            "L'",
            'Le',
            'La',
        ];
        $series = $series->sortBy(function ($serie, $key) use ($articles) {
            $title = $serie->title;
            $title = str_replace($articles, '', $title);
            $title = stripAccents($title);

            // echo $title.'<br/>';

            return $title;
        });

        if ($debug) {
            foreach ($series as $serie) {
                echo $serie->title.'<br>';
            }
        }

        if (null !== $perPage) {
            $series = $series->paginate($perPage);
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
