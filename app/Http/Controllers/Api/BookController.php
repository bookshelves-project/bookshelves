<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookCollectionResource;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookController extends ApiController
{
    #[Get('/', name: 'books.index')]
    public function index(Request $request) {
        $models = Book::available()
            ->orderBy('slug_sort')
            ->paginate(32)
        ;

        return BookCollectionResource::collection($models);
    }

    #[Get('/{author_slug}/{book_slug}', name: 'books.show')]
    public function show(Request $request, Author $author, Book $book)
    {
        return BookResource::make($book);
    }
}
