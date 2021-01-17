<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SerieResource extends JsonResource
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
        $books = null;
        $cover = null;
        if ($this->books) {
            $books = BookCollection::collection($this->books);
            $books_number = sizeof($books);
            $book = $books[0];
            $cover = $book->cover ? config('app.url').'/'.$book->cover : null;
        }

        return [
            'title'        => $this->title,
            'slug'         => $this->slug,
            'author'       => $book->author->name,
            'books_number' => $books_number,
            'books'        => $books,
            'cover'        => $cover,
        ];
    }
}
