<?php

namespace App\Http\Controllers\Api\Opds;

use Route;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\Bookshelves\OpdsProvider;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::orderBy('title_sort')->get();
        $result = OpdsProvider::template(data: $series, endpoint: 'serie', route: route(Route::currentRouteName(), [
            'version' => 'v1.2',
        ]));

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function show(string $author_slug, string $serie_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $serie = $author->series->firstWhere('slug', $serie_slug);
        $route = route(Route::currentRouteName(), [
            'version' => 'v1.2',
            'author'  => $author_slug,
            'serie'   => $serie_slug,
        ]);
        $result = OpdsProvider::template(endpoint: 'serie', data: $serie, route: $route);

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
