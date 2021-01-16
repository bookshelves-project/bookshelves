<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $books = null;
        $cover = null;
        if ($this->books) {
            $books = BookCollection::collection($this->books);
            $books_number = sizeof($books);
            $book = $books->random();
            $cover = $book->cover ? image_cache($book->cover, 'book_thumbnail') : null;
        }

        return [
            'lastname'     => $this->lastname,
            'firstname'    => $this->firstname,
            'name'         => $this->name,
            'slug'         => $this->slug,
            'books_number' => $books_number,
            'cover'        => $cover,
            'links'        => [
                'show' => config('app.url')."/api/authors/$this->slug",
            ],
        ];
    }
}
