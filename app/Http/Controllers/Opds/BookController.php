<?php

namespace App\Http\Controllers\Opds;

use App\Facades\OpdsBase;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/{book}', name: 'opds.books.show')]
    public function show(string $book)
    {
        $book = Book::query()
            ->where('slug', $book)
            ->firstOrFail();

        OpdsBase::app()
            ->title("Book {$book->title}")
            ->feeds(OpdsBase::bookToEntry($book))
            ->send(true);
    }
}
