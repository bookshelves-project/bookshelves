<?php

namespace App\Http\Controllers\Opds;

use App\Enums\EntitiesEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Services\OpdsService;
use Route;

/**
 * @hideFromAPIDocumentation
 */
class AuthorController extends Controller
{
    public function index(string $version)
    {
        $entities = Author::with('books', 'media')->orderBy('lastname')->get();

        $current_route = route(Route::currentRouteName(), ['version' => $version]);
        $opdsService = new OpdsService(
            version: $version,
            entity: EntitiesEnum::AUTHOR(),
            route: $current_route,
            data: $entities
        );
        $result = $opdsService->template();

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function show(string $version, string $author_slug)
    {
        $author = Author::with('books.authors', 'books.tags', 'books.media', 'books.serie', 'books.language')->whereSlug($author_slug)->firstOrFail();
        $books = $author->books;

        $current_route = route(Route::currentRouteName(), [
            'version' => $version,
            'author' => $author_slug,
        ]);
        $opdsService = new OpdsService(
            version: $version,
            entity: EntitiesEnum::BOOK(),
            route: $current_route,
            data: $books
        );
        $result = $opdsService->template("{$author->lastname} {$author->firstname}");

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
