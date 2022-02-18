<?php

namespace App\Http\Controllers\Front\Opds;

use App\Enums\EntitiesEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Services\OpdsService;
use Illuminate\Http\Request;
use Route;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('features/opds/{version}/books')]
class BookController extends Controller
{
    #[Get('/{author}/{book]', name: 'front.opds.books.show')]
    public function show(Request $request, string $version, string $author_slug, string $book_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $book = Book::whereSlug($book_slug)->firstOrFail();
        if ($book->meta_author !== $author_slug) {
            return abort(404);
        }

        $current_route = route(Route::currentRouteName(), [
            'version' => $version,
            'author' => $author_slug,
            'book' => $book_slug,
        ]);
        $opdsService = new OpdsService(
            version: $version,
            entity: EntitiesEnum::book(),
            route: $current_route,
            data: $book
        );
        $result = $opdsService->template("{$author->lastname} {$author->firstname}");

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
