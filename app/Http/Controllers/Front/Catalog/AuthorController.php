<?php

namespace App\Http\Controllers\Front\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Utils\BookshelvesTools;
use Illuminate\Http\Request;

/**
 * @hideFromAPIDocumentation
 */
class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::with(['media'])->get();
        $authors = BookshelvesTools::chunkByAlpha($authors, 'lastname');

        return view('front.pages.catalog.authors.index', compact('authors'));
    }

    public function character(Request $request)
    {
        $character = $request->character;
        $authors = Author::with(['media'])->get();

        $chunks = BookshelvesTools::chunkByAlpha($authors, 'lastname');
        $current_chunk = [];
        $authors = $chunks->first(function ($value, $key) use ($character) {
            return $key === strtoupper($character);
        });

        $authors = EntityResource::collection($authors);

        return view('front.pages.catalog.authors.character', compact('authors', 'character'));
    }

    public function show(Request $request, string $character, string $slug)
    {
        $author = Author::whereSlug($slug)->firstOrFail();

        $books = EntityResource::collection($author->books);
        $author = AuthorResource::make($author);
        $author = json_decode($author->toJson());

        return view('front.pages.catalog.authors._slug', compact('author', 'books'));
    }
}
