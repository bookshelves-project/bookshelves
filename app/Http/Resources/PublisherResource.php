<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        // $books = null;
        // $cover = null;
        // if ($this->books) {
        //     $books = BookCollection::collection($this->books);
        //     $books_number = sizeof($books);
        //     $book = $books->random();
        //     $cover = $book->cover ? image_cache($book->cover, 'picture_thumbnail') : null;
        // }

        return [
            'name'     => $this->name,
            'slug'     => $this->slug,
        ];
    }
}
