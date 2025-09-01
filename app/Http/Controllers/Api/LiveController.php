<?php

namespace App\Http\Controllers\Api;

use App\Enums\LibraryTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Library;
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
            ->inRandomOrder()
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
        $types = LibraryTypeEnum::toArray();

        $librairies = Library::query()
            ->withCount('books')
            ->get()
            ->groupBy('type');

        foreach ($librairies as $type => $libraries) {
            $types[$type] = $libraries->sum('books_count');
        }

        $booksAddedAtRecently = Book::query()
            ->where('added_at', '>=', now()->subDays(7))
            ->count();

        return response()->json([
            'recently_added_books' => $booksAddedAtRecently,
            ...$types,
        ]);
    }
}
