<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class BookLightestResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     *
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Book $book */
        $book = $this;

        $base = [
            'title'        => $book->title,
            'slug'         => $book->slug,
            'author'       => $book->author->slug,
            'serie'        => $book->serie?->title,
            'meta'         => [
                'show'        => $book->show_link,
            ],
        ];

        return $base;
    }
}
