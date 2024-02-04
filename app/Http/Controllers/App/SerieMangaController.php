<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series-mangas')]
class SerieMangaController extends Controller
{
    #[Get('/', name: 'series.mangas.index')]
    public function index(Request $request)
    {
        return $this->getQueryForSeries($request, Serie::whereIsManga(), 'Manga series', [
            ['label' => 'Manga series', 'route' => ['name' => 'series.mangas.index']],
        ], squareCovers: true);
    }

    #[Get('/{serie_slug}', name: 'series.mangas.show')]
    public function show(Serie $serie)
    {
        return $this->getSerie($serie);
    }
}
