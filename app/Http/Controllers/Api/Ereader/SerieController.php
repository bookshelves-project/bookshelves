<?php

namespace App\Http\Controllers\Api\Ereader;

use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Serie\SerieResource;
use App\Http\Resources\Book\BookLightResource;

class SerieController extends Controller
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

        return view('pages/api/opds/ereader', compact('books', 'links'));
    }

    public function show(Request $request, string $author, string $slug)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($slug)->firstOrFail();
        $serie = SerieResource::make($serie);
        $serie = json_decode($serie->toJson());

        return view('pages/api/opds/series/_slug', compact('serie'));
    }
}
