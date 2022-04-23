<?php

namespace App\Http\Controllers\Front\Opds;

use App\Engines\OpdsEngine;
use App\Enums\EntityEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('opds/{version}/series')]
class SerieController extends Controller
{
    #[Get('/', name: 'front.opds.series')]
    public function index(Request $request)
    {
        $engine = OpdsEngine::create($request);
        $entities = Serie::with('books', 'authors', 'media')
            ->orderBy('slug_sort')
            ->get()
        ;

        return $engine->entities(EntityEnum::author, $entities);
    }

    #[Get('/{author}/{serie}', name: 'front.opds.series.show')]
    public function show(Request $request, string $version, string $author_slug, string $serie_slug)
    {
        $engine = OpdsEngine::create($request);
        $entity = Author::with('series.books', 'series.books.authors', 'series.books.tags', 'series.books.media', 'series.books.serie', 'series.books.language')
            ->whereSlug($author_slug)
            ->firstOrFail()
        ;
        $serie = $entity->series->firstWhere('slug', $serie_slug);
        $books = $serie->books;

        return $engine->entities(EntityEnum::book, $books, "{$entity->lastname} {$entity->firstname}");
    }
}
