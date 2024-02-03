<?php

namespace App\Http\Controllers\App;

use App\Enums\BookTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/', name: 'books.index')]
    public function index(Request $request)
    {
        return $this->getQueryForBooks($request, Book::whereIsBook(), 'Books', [
            ['label' => 'Books', 'route' => ['name' => 'books.index']],
        ]);
    }

    #[Get('/{book_slug}', name: 'books.show')]
    public function show(Book $book)
    {
        $book->load([
            'authors',
            'serie',
            'serie.books',
            'serie.books.media',
            'tags',
            'media',
            'publisher',
            'language',
        ]);

        return inertia('Books/Show', [
            'book' => $book,
            'square' => $book->type === BookTypeEnum::audiobook,
        ]);
    }

    #[Get('/related/{book_slug}', name: 'books.related')]
    public function related(Book $book)
    {
        $related = $book->getRelated();

        return inertia('Books/Show', [
            'book' => $book,
            'square' => $book->type === BookTypeEnum::audiobook,
        ]);
    }
}
