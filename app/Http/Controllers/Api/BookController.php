<?php

namespace App\Http\Controllers\Api;

use Storage;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage');

        $books = Book::with('serie')->orderBy('title');
        if (null !== $perPage) {
            $books = $books->paginate($perPage);
        } else {
            $books = $books->get();
        }

        $books = BookCollection::collection($books);

        return $books;
    }

    public function count()
    {
        return Book::count();
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['title', 'author.firstname', 'author.lastname', 'serie.title'], $searchTerm)->get();

        return BookResource::collection($books);
    }

    public function show(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereAuthorId($author->id)->whereSlug($book)->firstOrFail();
        $book = BookResource::make($book);

        return $book;
    }

    public function download(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereAuthorId($author->id)->whereSlug($book)->firstOrFail();
        $book = BookResource::make($book);

        $ebook_path = str_replace('storage/', '', $book->epub->path);

        return Storage::disk('public')->download($ebook_path);
    }
}
