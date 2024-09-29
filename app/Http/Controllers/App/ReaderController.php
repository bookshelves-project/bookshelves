<?php

namespace App\Http\Controllers\App;

use App\Enums\LibraryTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('reader')]
class ReaderController extends Controller
{
    #[Get('/', name: 'reader.index')]
    public function index()
    {
        $book = Book::query()
            ->whereLibraryType(LibraryTypeEnum::book)
            ->first();

        return inertia('Reader', [
            'book' => $book,
        ]);
    }
}
