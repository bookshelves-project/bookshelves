<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('audiobooks')]
class AudiobookController extends Controller
{
    #[Get('/', name: 'audiobooks.index')]
    public function index(Request $request)
    {
        return $this->getQueryForBooks($request, Book::whereIsAudiobook(), 'Audiobooks', [
            ['label' => 'Audiobooks', 'route' => ['name' => 'audiobooks.index']],
        ], squareCovers: true);
    }

    #[Get('/{book:slug}', name: 'audiobooks.show')]
    public function show(Book $book)
    {
        return $this->loadBook($book);
    }
}
