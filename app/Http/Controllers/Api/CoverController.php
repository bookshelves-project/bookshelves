<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Library;
use App\Models\Serie;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('covers')]
class CoverController extends Controller
{
    #[Get('/{library:slug}/{book:slug}', name: 'api.books.cover')]
    public function book(Library $library, Book $book)
    {
        $book->loadMissing([
            'media',
        ]);

        $path = $book->cover_path;

        return response()->file($path, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }

    #[Get('/{library:slug}/series/{serie:slug}', name: 'api.series.cover')]
    public function serie(Library $library, Serie $serie)
    {
        $serie->loadMissing([
            'media',
        ]);

        $path = $serie->cover_path;

        return response()->file($path, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }
}
