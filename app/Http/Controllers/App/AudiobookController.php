<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('audiobooks')]
class AudiobookController extends Controller
{
    #[Get('/', name: 'audiobooks.index')]
    public function index()
    {
        $books = Book::query()
            ->with(['authors', 'serie', 'tags', 'media'])
            ->whereIsAudiobook()
            ->orderBy('slug_sort')
            ->get()
            ->append(['cover_thumbnail', 'cover_color']);

        return inertia('Books/Index', [
            'books' => $books,
        ]);
    }

    #[Get('/{audiobook_slug}', name: 'audiobooks.show')]
    public function show(Book $book)
    {
        $book->load(['authors', 'serie', 'tags', 'media'])
            ->append(['cover_standard', 'cover_social', 'cover_color']);

        return inertia('Books/Show', [
            'book' => $book,
        ]);
    }
}
