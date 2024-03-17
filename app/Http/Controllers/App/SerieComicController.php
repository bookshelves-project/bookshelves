<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series-comics')]
class SerieComicController extends Controller
{
    #[Get('/', name: 'series.comics.index')]
    public function index(Request $request)
    {
        return $this->getQueryForSeries($request, Serie::whereIsComic(), 'Comic series', [
            ['label' => 'Comic series', 'route' => ['name' => 'series.comics.index']],
        ]);
    }

    #[Get('/{serie:slug}', name: 'series.comics.show')]
    public function show(Serie $serie)
    {
        return $this->getSerie($serie);
    }
}
