<?php

namespace App\Http\Controllers\Api\Opds;

use Response;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\Bookshelves\OpdsProvider;
use App\Http\Resources\Book\BookLightestResource;

class OpdsController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.api.opds.index');
    }

    public function feed(Request $request)
    {
        $books = Book::orderBy('title_sort')->limit(30)->get();
        $books = BookLightestResource::collection($books);
        $books = $books->toArray($request);

        $books_list = [];
        foreach ($books as $key => $book) {
            array_push($books_list, $book['title']);
        }

        $result = OpdsProvider::template();

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function books()
    {
    }

    public function series()
    {
    }

    public function authors()
    {
    }
}
