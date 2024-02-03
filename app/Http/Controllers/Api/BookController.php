<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Models\Book;
use Kiwilan\Steward\Utils\PaginatorHelper;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/related/{book_slug}', name: 'api.books.related')]
    public function related(Book $book)
    {
        if ($book->tags->count() >= 1) {
            $related = $book->getRelated();

            if ($related->isNotEmpty()) {
                return EntityResource::collection(PaginatorHelper::paginate($related));
            }
        }

        return response()->json(
            data: [
                'data' => [],
            ],
            status: 200
        );
    }
}
