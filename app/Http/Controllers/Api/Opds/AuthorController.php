<?php

namespace App\Http\Controllers\Api\Opds;

use Route;
use App\Models\Author;
use App\Http\Controllers\Controller;
use App\Providers\Bookshelves\OpdsProvider;

class AuthorController extends Controller
{
    public function index()
    {
        $entities = Author::orderBy('lastname')->get();
        $result = OpdsProvider::template(endpoint: 'author', data: $entities, route: route(Route::currentRouteName(), [
            'version' => 'v1.2',
        ]));

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function show(string $author_slug)
    {
        $route = route(Route::currentRouteName(), [
            'version' => 'v1.2',
            'author'  => $author_slug,
        ]);
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $result = OpdsProvider::template(endpoint: 'author', data: $author, route: $route);

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
