<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Utils\BookshelvesTools;
use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Search\SearchAuthorResource;

/**
 * @hideFromAPIDocumentation
 */
class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::with(['media'])->get();
        $authors = BookshelvesTools::chunkByAlpha($authors, 'lastname');

        return view('pages.features.catalog.authors.index', compact('authors'));
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

        $authors = SearchAuthorResource::collection($authors);
        $authors = collect($authors);

        return view('pages.features.catalog.authors.character', compact('authors'));
    }

    public function show(Request $request, string $character, string $slug)
    {
        $author = Author::whereSlug($slug)->firstOrFail();

        $books = BookLightResource::collection($author->books);
        $author = AuthorResource::make($author);
        $author = json_decode($author->toJson());

        return view('pages.features.catalog.authors._slug', compact('author', 'books'));
    }
}
