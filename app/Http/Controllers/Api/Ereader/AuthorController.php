<?php

namespace App\Http\Controllers\Api\Ereader;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookLightResource;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::all();

        $books = $books->sortBy(function ($book) {
            return $book->sort_name;
        });
        $books = $books->paginate(32);
        $books = BookLightResource::collection($books);
        $links = $books->onEachSide(1)->links();
        $books = json_decode($books->toJson());

        return view('pages/api/ereader', compact('books', 'links'));
    }

    public function show(Request $request, string $slug)
    {
        $author = Author::whereSlug($slug)->firstOrFail();
        $author = AuthorResource::make($author);
        $author = json_decode($author->toJson());

        return view('pages/api/authors/_slug', compact('author'));
    }
}
