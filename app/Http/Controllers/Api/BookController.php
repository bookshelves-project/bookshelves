<?php

namespace App\Http\Controllers\Api;

use App\Enums\LibraryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Models\Book;
use Kiwilan\Steward\Utils\PaginatorHelper;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/related/{book:slug}', name: 'api.books.related')]
    public function related(Book $book)
    {
        $book->loadMissing('tags');

        if ($book->tags->count() >= 1) {
            $related = $book->getRelated();

            if ($related->isNotEmpty()) {
                return EntityResource::collection(PaginatorHelper::paginate($related));
            }
        }

        return response()->json([
            'data' => [],
        ]);
    }

    #[Get('/latest', name: 'api.books.latest')]
    public function latest()
    {
        return response()->json([
            'data' => $this->getBooks('added_at', true, 20),
        ]);
    }

    #[Get('/released', name: 'api.books.released')]
    public function released()
    {
        return response()->json([
            'data' => $this->getBooks('released_on', true, 20),
        ]);
    }

    #[Get('/latest/{type}', name: 'api.books.latest.type')]
    public function latestType(string $type)
    {
        $type = LibraryTypeEnum::from($type);

        return response()->json([
            'data' => $this->getBooks('added_at', true, 20, $type),
        ]);
    }
}
