<?php

namespace App\Http\Controllers\Front\Opds;

use App\Engines\OpdsEngine;
use App\Enums\EntityEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('{version}/authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'authors.index')]
    public function index(Request $request)
    {
        $engine = OpdsEngine::create($request);
        $entities = Author::with('books', 'media')
            ->orderBy('lastname')
            ->get()
        ;

        return $engine->entities(EntityEnum::author, $entities);
    }

    #[Get('/{author}', name: 'authors.show')]
    public function show(Request $request, string $version, string $author_slug)
    {
        $engine = OpdsEngine::create($request);
        $entity = Author::with('books.authors', 'books.tags', 'books.media', 'books.serie', 'books.language')
            ->whereSlug($author_slug)
            ->firstOrFail()
        ;
        $books = $entity->books;

        return $engine->entities(EntityEnum::book, $books, "{$entity->lastname} {$entity->firstname}");
    }
}
