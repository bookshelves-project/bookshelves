<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Search\SearchAuthorResource;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::with(['media'])->get();

        $authors = SearchAuthorResource::collection($authors);
        $authors = collect($authors);

        return view('pages.api.catalog.authors.index', compact('authors'));
    }

    public function show(Request $request, string $slug)
    {
        $author = Author::whereSlug($slug)->firstOrFail();

        $books = BookLightResource::collection($author->books);
        $books = json_decode($books->toJson());

        $author = AuthorResource::make($author);
        $author = json_decode($author->toJson());

        return view('pages.api.catalog.authors._slug', compact('author', 'books'));
    }
}
