<?php

namespace App\Http\Controllers\Opds;

use Route;
use App\Models\Serie;
use App\Models\Author;
use App\Enums\EntitiesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\Bookshelves\OpdsProvider;

/**
 * @hideFromAPIDocumentation
 */
class SerieController extends Controller
{
    public function index(Request $request, string $version)
    {
        $entities = Serie::with('books', 'authors', 'media')->orderBy('title_sort')->get();

        $current_route = route(Route::currentRouteName(), ['version' => $version]);
        $opdsProvider = new OpdsProvider(
            version: $version,
            entity: EntitiesEnum::SERIE(),
            route: $current_route,
            data: $entities
        );
        $result = $opdsProvider->template();

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function show(Request $request, string $version, string $author_slug, string $serie_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $entity = $author->series->firstWhere('slug', $serie_slug);

        $current_route = route(Route::currentRouteName(), [
            'version' => $version,
            'author'  => $author_slug,
            'serie'   => $serie_slug,
        ]);
        $opdsProvider = new OpdsProvider(
            version: $version,
            entity: EntitiesEnum::SERIE(),
            route: $current_route,
            data: $entity
        );
        $result = $opdsProvider->template();
        
        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
