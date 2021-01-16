<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SerieCollection extends JsonResource
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
            $cover = $books[0]->cover ? image_cache($books[0]->cover, 'book_thumbnail') : null;
        }

        return [
            'title'        => $this->title,
            'slug'         => $this->slug,
            'books_number' => $books_number,
            'cover'        => $cover,
            'links'        => [
                'show' => config('app.url')."/api/series/$this->slug",
            ],
        ];
    }
}
