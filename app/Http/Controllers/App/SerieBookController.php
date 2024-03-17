<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series-books')]
class SerieBookController extends Controller
{
    #[Get('/', name: 'series.books.index')]
    public function index(Request $request)
    {
        return $this->getQueryForSeries($request, Serie::whereIsBook(), 'Book series', [
            ['label' => 'Book series', 'route' => ['name' => 'series.books.index']],
        ]);
    }

    #[Get('/{serie:slug}', name: 'series.books.show')]
    public function show(Serie $serie)
    {
        return $this->getSerie($serie);
    }
}
