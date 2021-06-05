<?php

namespace App\Http\Resources\Tag;

use App\Enums\CountSizeEnum;
use App\Http\Resources\Book\BookLightestResource;
use App\Http\Resources\Book\BookLightResource;
use App\Models\Book;
use Spatie\Tags\Tag;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Tag $resource
 */
class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $books = Book::withAllTags([$this->resource])->get();
        $books = $books->sortBy(function ($book) {
            return $book->sort_name;
        });

        $resource = TagLightResource::make($this->resource)->toArray($request);
        $resource = array_merge($resource, [
            'books' => BookLightResource::collection($books)
        ]);

        return $resource;
    }
}
