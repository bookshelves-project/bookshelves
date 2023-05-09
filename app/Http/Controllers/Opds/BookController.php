<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsConfig;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Kiwilan\Opds\Opds;
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

        return Opds::response(
            app: OpdsConfig::app(),
            entries: [
                OpdsConfig::bookToEntry($book),
            ],
            title: "Book {$book->title}",
        );
    }
}
