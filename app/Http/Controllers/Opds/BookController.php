<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsConfig;
use App\Engines\OpdsEngine;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/{author}/{book}', name: 'books.show')]
    public function show(string $author_slug, string $book_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $book = Book::whereAuthorMainId($author->id)
            ->whereSlug($book_slug)
            ->firstOrFail()
        ;

        $module = OpdsEngine::make(
            app: OpdsConfig::app(),
            entries: [
                OpdsConfig::bookToEntry($book),
            ],
            title: "Book {$book->title}",
        );

        return $module->response();
    }
}
