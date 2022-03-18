<?php

namespace App\Http\Controllers\Front\Opds;

use App\Enums\EntityEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Serie;
use App\Services\OpdsService;
use Illuminate\Http\Request;
use Route;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('opds/{version}/series')]
class SerieController extends Controller
{
    #[Get('/', name: 'front.opds.series')]
    public function index(Request $request, string $version)
    {
        $entities = Serie::with('books', 'authors', 'media')->orderBy('slug_sort')->get();

        $current_route = route(Route::currentRouteName(), ['version' => $version]);
        $opdsService = new OpdsService(
            version: $version,
            entity: EntityEnum::serie,
            route: $current_route,
            data: $entities
        );
        $result = $opdsService->template();

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    #[Get('/{serie}', name: 'front.opds.series.show')]
    public function show(Request $request, string $version, string $author_slug, string $serie_slug)
    {
        $author = Author::with('series.books', 'series.books.authors', 'series.books.tags', 'series.books.media', 'series.books.serie', 'series.books.language')->whereSlug($author_slug)->firstOrFail();
        $serie = $author->series->firstWhere('slug', $serie_slug);
        $books = $serie->books;

        $current_route = route(Route::currentRouteName(), [
            'version' => $version,
            'author' => $author_slug,
            'serie' => $serie_slug,
        ]);
        $opdsService = new OpdsService(
            version: $version,
            entity: EntityEnum::book,
            route: $current_route,
            data: $books
        );
        $result = $opdsService->template();

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
