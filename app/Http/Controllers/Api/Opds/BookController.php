<?php

namespace App\Http\Controllers\Api\Opds;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookLightResource;

class BookController extends Controller
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

        return view('pages/api/opds/books/index', compact('books', 'links'));
    }

    public function show(Request $request, string $author, string $slug)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($slug)->firstOrFail();
        $book = BookResource::make($book);
        $book = json_decode($book->toJson());

        return view('pages/api/opds/books/_slug', compact('book'));
    }
}
