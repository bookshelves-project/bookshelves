<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/', name: 'books.index')]
    public function index()
    {
        $books = Book::with(['authors', 'serie', 'tags', 'media'])
            ->whereRelation('serie', 'title', 'A comme Association')
            ->orderBy('slug_sort')
            ->get()
            ->append(['cover_thumbnail', 'cover_color']);
        ray($books)->purple();

        $books = Book::with(['authors', 'serie', 'tags', 'media'])
            ->orderBy('slug_sort')
            ->get()
            ->append(['cover_thumbnail', 'cover_color']);

        return inertia('Books/Index', [
            'books' => $books,
        ]);
    }

    #[Get('/{book_slug}', name: 'books.show')]
    public function show(Book $book)
    {
        $book->load(['authors', 'serie', 'tags', 'media'])
            ->append(['cover_standard', 'cover_social', 'cover_color']);

        return inertia('Books/Show', [
            'book' => $book,
        ]);
    }
}
