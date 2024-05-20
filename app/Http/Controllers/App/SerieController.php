<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series')]
class SerieController extends Controller
{
    #[Get('/', name: 'series.index')]
    public function index(Request $request)
    {
        return $this->getQueryForSeries($request, Serie::whereIsBook(), 'Book series', [
            ['label' => 'Book series', 'route' => ['name' => 'series.books.index']],
        ]);
    }

    #[Get('/{library:slug}/{serie:slug}', name: 'series.show')]
    public function show(Library $library, string $serie)
    {
        $serie = Serie::where('slug', $serie)->first();

        return inertia('Series/Show', [
            'serie' => $serie->loadMissing(['books', 'books.media', 'media']),
            'library' => $library,
        ]);
    }
}
