<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['title', 'author.name', 'author.firstname', 'author.lastname', 'serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return BookResource::collection($books);
    }

    public function byBook(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['title'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return BookResource::collection($books);
    }

    public function byAuthor(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['author.name', 'author.firstname', 'author.lastname'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return BookResource::collection($books);
    }

    public function bySerie(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return BookResource::collection($books);
    }
}
