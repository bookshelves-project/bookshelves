<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Serie;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('live')]
class LiveController extends Controller
{
    #[Get('/random-covers', name: 'api.live.random-covers')]
    public function randomPosters()
    {
        $books = Book::query()
            ->with(['media'])
            ->latest()
            ->limit(5)
            ->get();

        $posters = [];
        foreach ($books as $book) {
            $posters[] = $book->cover_standard;
        }

        shuffle($posters);

        return response()->json($posters);
    }

    #[Get('/statistics', name: 'api.live.statistics')]
    public function statistics()
    {
        $booksAddedAtRecently = Book::query()
            ->where('added_at', '>=', now()->subDays(7))
            ->count();

        return response()->json([
            'new' => $booksAddedAtRecently,
            'books' => Book::count(),
            'series' => Serie::count(),
        ]);
    }
}
