<?php

namespace App\Http\Resources\Tag;

use App\Models\Book;
use Spatie\Tags\Tag;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Search\SearchBookResource;

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
        $books = SearchBookResource::collection($books);

        $resource = TagLightResource::make($this->resource)->toArray($request);
        $resource = array_merge($resource, [
            'books' => $books,
        ]);

        return $resource;
    }
}
