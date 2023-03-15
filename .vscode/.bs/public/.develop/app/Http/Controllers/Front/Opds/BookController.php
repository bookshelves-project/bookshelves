<?php

namespace App\Http\Controllers\Front\Opds;

use App\Engines\OpdsEngine;
use App\Enums\EntityEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('opds/{version}/books')]
class BookController extends Controller
{
    #[Get('/{author}/{book}', name: 'front.opds.books.show')]
    public function show(Request $request, string $version, string $author_slug, string $book_slug)
    {
        $engine = OpdsEngine::create($request);
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $book = Book::whereSlug($book_slug)->firstOrFail();

        return $engine->entities(EntityEnum::book, $book, "{$book->title}");
    }
}
