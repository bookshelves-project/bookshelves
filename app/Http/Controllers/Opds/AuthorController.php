<?php

namespace App\Http\Controllers\Opds;

use Route;
use App\Models\Author;
use App\Enums\EntitiesEnum;
use App\Http\Controllers\Controller;
use App\Providers\Bookshelves\OpdsProvider;

/**
 * @hideFromAPIDocumentation
 */
class AuthorController extends Controller
{
    public function index(string $version)
    {
        $entities = Author::with('books', 'media')->orderBy('lastname')->get();

        $current_route = route(Route::currentRouteName(), ['version' => $version]);
        $opdsProvider = new OpdsProvider(
            version: $version,
            entity: EntitiesEnum::AUTHOR(),
            route: $current_route,
            data: $entities
        );
        $result = $opdsProvider->template();

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function show(string $version, string $author_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();

        $current_route = route(Route::currentRouteName(), [
            'version' => $version,
            'author'  => $author_slug,
        ]);
        $opdsProvider = new OpdsProvider(
            version: $version,
            entity: EntitiesEnum::AUTHOR(),
            route: $current_route,
            data: $author
        );
        $result = $opdsProvider->template("$author->lastname $author->firstname");

        // $books = $author->books;
        // $result = OpdsProvider::template(entity: Author::class, endpoint: 'author', data: $books, route: $route, id: "authors:$author->slug", title: "Author: $author->name");

        
        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
