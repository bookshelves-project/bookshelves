<?php

namespace App\Http\Resources\Publisher;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Search\SearchBookResource;

class PublisherResource extends JsonResource
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
        /** @var Publisher $publisher */
        $publisher = $this;

        $books = Book::wherePublisherId([$publisher->id])->get();
        $books = SearchBookResource::collection($books);

        $resource = PublisherLightResource::make($publisher)->toArray($request);
        $resource = array_merge($resource, [
            'books' => $books,
        ]);

        return $resource;
    }
}
