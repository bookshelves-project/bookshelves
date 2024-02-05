<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('size')]
class SizeController extends Controller
{
    #[Get('/book/{book_id}', name: 'api.sizes.book')]
    public function book(Request $request, Book $book)
    {
        /** @var ?BookTypeEnum $type */
        $type = $book->type;

        if ($type !== BookTypeEnum::audiobook) {
            $size = filesize($book->physical_path);
        } else {
            $audiobooks = $book->audiobooks;
            $size = $audiobooks
                ->map(fn (Audiobook $audiobook) => filesize($audiobook->physical_path))
                ->sum();
        }

        return response()->json([
            'extension' => $type === BookTypeEnum::audiobook ? 'zip' : $book->extension,
            'size' => $size,
        ]);
    }

    #[Get('/serie/{serie_id}', name: 'api.sizes.serie')]
    public function serie(Request $request, Serie $serie)
    {
        $size = 0;
        $serie->load('books');
        foreach ($serie->books as $book) {
            if ($book->type !== BookTypeEnum::audiobook) {
                $size += filesize($book->physical_path);
            } else {
                $book->load('audiobooks');
                $audiobooks = $book->audiobooks;
                $size += $audiobooks
                    ->map(fn (Audiobook $audiobook) => filesize($audiobook->physical_path))
                    ->sum();
            }
        }

        return response()->json([
            'extension' => 'zip',
            'size' => $size,
        ]);
    }
}
