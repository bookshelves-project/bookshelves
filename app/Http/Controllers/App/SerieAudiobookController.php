<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series-audiobooks')]
class SerieAudiobookController extends Controller
{
    #[Get('/', name: 'series.audiobooks.index')]
    public function index(Request $request)
    {
        return $this->getQueryForSeries($request, Serie::whereIsAudiobook(), 'Audiobook series', [
            ['label' => 'Audiobook series', 'route' => ['name' => 'series.audiobooks.index']],
        ], squareCovers: true);
    }

    #[Get('/{serie_slug}', name: 'series.audiobooks.show')]
    public function show(Serie $serie)
    {
        return $this->getSerie($serie, true);
    }
}
