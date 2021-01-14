<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage');
        if (null === $request->get('perPage')) {
            $perPage = 10;
        }
        $books = Book::with('serie')->orderBy('serie_id')->orderBy('serie_number')->paginate($perPage);

        $books = BookResource::collection($books);
        // dd($books);

        return $books;
    }

    public function show(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereAuthorId($author->id)->whereSlug($book)->firstOrFail();
        $book = BookResource::make($book);

        return $book;
    }
}
