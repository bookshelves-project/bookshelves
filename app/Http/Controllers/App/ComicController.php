<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('comics')]
class ComicController extends Controller
{
    #[Get('/', name: 'comics.index')]
    public function index(Request $request)
    {
        return $this->getQueryForBooks($request, Book::whereIsComic(), 'Comics', [
            ['label' => 'Comics', 'route' => ['name' => 'comics.index']],
        ]);
    }

    #[Get('/{book_slug}', name: 'comics.show')]
    public function show(Book $book)
    {
        $book->load(['authors', 'serie', 'tags', 'media']);

        return inertia('Books/Show', [
            'book' => $book,
        ]);
    }
}
