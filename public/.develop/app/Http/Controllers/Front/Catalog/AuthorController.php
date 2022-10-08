<?php

namespace App\Http\Controllers\Front\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\EntityResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Kiwilan\Steward\Utils\Toolbox;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('catalog/authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'catalog.authors')]
    public function index(Request $request)
    {
        $authors = Author::with(['media'])->get();
        $authors = Toolbox::chunkByAlpha($authors, 'lastname');

        return view('front::pages.catalog.authors.index', compact('authors'));
    }

    #[Get('/{character}', name: 'catalog.authors.character')]
    public function character(Request $request)
    {
        $character = $request->character;
        $authors = Author::with(['media'])->get();

        $chunks = Toolbox::chunkByAlpha($authors, 'lastname');
        $current_chunk = [];
        $authors = $chunks->first(function ($value, $key) use ($character) {
            return $key === strtoupper($character);
        });

        $authors = EntityResource::collection($authors);

        return view('front::pages.catalog.authors.character', compact('authors', 'character'));
    }

    #[Get('/{character}/{author}', name: 'catalog.authors.show')]
    public function show(Request $request, string $character, string $slug)
    {
        $author = Author::whereSlug($slug)->firstOrFail();

        $books = EntityResource::collection($author->books->where('is_disabled', false));
        $author = AuthorResource::make($author);
        $author = json_decode($author->toJson());

        return view('front::pages.catalog.authors._slug', compact('author', 'books'));
    }
}
