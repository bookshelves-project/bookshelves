<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('serie')->orderBy('serie_id')->orderBy('serie_number')->get();

        $books = BookResource::collection($books);

        return $books;
    }
}
