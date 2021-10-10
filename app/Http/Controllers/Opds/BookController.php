<?php

namespace App\Http\Controllers\Opds;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

/**
 * @hideFromAPIDocumentation
 */
class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::orderBy('title_sort')->paginate(32);
        // $books = BookLightResource::collection($books);

        return response()->xml($books);
    }

    public function show(Request $request, string $author, string $slug)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($slug)->firstOrFail();
        $book = BookResource::make($book);
        $book = json_decode($book->toJson());

        return view('pages.api.opds.books._slug', compact('book'));
    }
}
