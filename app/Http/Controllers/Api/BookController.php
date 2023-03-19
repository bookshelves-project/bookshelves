<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/', name: 'books.index')]
    public function index(Request $request)
    {
        return HttpQuery::make(Book::class, $request)
            ->with(['authors', 'media', 'language', 'serie'])
            ->collection()
        ;
    }

    #[Get('/{author_slug}/{book_slug}', name: 'books.show')]
    public function show(Request $request, Author $author, Book $book)
    {
        return BookResource::make($book);
    }
}
