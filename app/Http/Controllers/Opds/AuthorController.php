<?php

namespace App\Http\Controllers\Opds;

use Route;
use App\Models\Author;
use App\Http\Controllers\Controller;
use App\Providers\Bookshelves\OpdsProvider;

/**
 * @hideFromAPIDocumentation
 */
class AuthorController extends Controller
{
    public function index(string $version)
    {
        $entities = Author::orderBy('lastname')->get();
        $result = OpdsProvider::template(entity: 'auhtor', endpoint: 'author', data: $entities, route: route(Route::currentRouteName(), [
            'version' => $version,
        ]));

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function show(string $version, string $author_slug)
    {
        $route = route(Route::currentRouteName(), [
            'version' => $version,
            'author'  => $author_slug,
        ]);
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $books = $author->books;
        $result = OpdsProvider::template(entity: Author::class, endpoint: 'author', data: $books, route: $route, id: "authors:$author->slug", title: "Author: $author->name");

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
