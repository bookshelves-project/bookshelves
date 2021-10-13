<?php

namespace App\Http\Controllers\Opds;

use App\Enums\EntitiesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Services\OpdsService;
use Illuminate\Http\Request;
use Route;

/**
 * @hideFromAPIDocumentation
 */
class BookController extends Controller
{
    public function show(Request $request, string $version, string $author_slug, string $book_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $book = Book::whereSlug($book_slug)->firstOrFail();
        if ($book->meta_author !== $author_slug) {
            return abort(404);
        }
        // $book = BookResource::make($book);
        // $book = json_decode($book->toJson());

        // $author = Author::with('books.authors', 'books.tags', 'books.media', 'books.serie', 'books.language')->whereSlug($author_slug)->firstOrFail();
        // $books = $author->books;

        $current_route = route(Route::currentRouteName(), [
            'version' => $version,
            'author' => $author_slug,
            'book' => $book_slug,
        ]);
        $opdsService = new OpdsService(
            version: $version,
            entity: EntitiesEnum::BOOK(),
            route: $current_route,
            data: $book
        );
        $result = $opdsService->template("{$author->lastname} {$author->firstname}");

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
