<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('size')]
class SizeController extends Controller
{
    #[Get('/book/{book:id}', name: 'api.sizes.book')]
    public function book(Request $request, Book $book)
    {
        $book->loadMissing(['library', 'audiobookTracks']);

        if ($book->library?->type->isAudiobook()) {
            $size = $book->audiobookTracks
                ->map(fn (AudiobookTrack $track) => $track->file->size)
                ->sum();
        } else {
            $size = $book->file->size;
        }

        return response()->json([
            'extension' => $book->library?->type->isAudiobook() ? 'zip' : $book->file->extension,
            'size' => $size,
        ]);
    }

    #[Get('/serie/{serie:id}', name: 'api.sizes.serie')]
    public function serie(Request $request, Serie $serie)
    {
        $size = 0;
        $serie->loadMissing(['books', 'books.library', 'books.audiobookTracks']);

        foreach ($serie->books as $book) {
            if ($book->library?->type->isAudiobook()) {
                $size += $book->audiobookTracks
                    ->map(fn (AudiobookTrack $track) => $track->file->size)
                    ->sum();
            } else {
                $size += $book->file->size;
            }
        }

        return response()->json([
            'extension' => 'zip',
            'size' => $size,
        ]);
    }
}
