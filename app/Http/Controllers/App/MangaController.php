<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('mangas')]
class MangaController extends Controller
{
    #[Get('/', name: 'mangas.index')]
    public function index(Request $request)
    {
        return $this->getQueryForBooks($request, Book::whereIsManga(), 'Mangas', [
            ['label' => 'Mangas', 'route' => ['name' => 'mangas.index']],
        ]);
    }

    #[Get('/{book:slug}', name: 'mangas.show')]
    public function show(Book $book)
    {
        return $this->loadBook($book);
    }
}
