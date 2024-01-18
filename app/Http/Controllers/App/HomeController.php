<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function index()
    {
        $books = Book::with(['authors', 'serie', 'tags', 'media'])
            ->orderBy('title')
            ->get()
            ->append(['cover_item_thumbnail']);

        return inertia('Home', [
            'books' => $books->random(10),
        ]);
    }
}
