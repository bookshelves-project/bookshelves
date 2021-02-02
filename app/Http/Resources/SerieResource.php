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
        }
        if ($this->cover) {
            $cover = $book->cover->thumbnail;
        }
        $downloadLink = config('app.url')."/api/series/download/$this->slug";
        $size = [];
        foreach ($books as $key => $book) {
            array_push($size, $book->epub->size_bytes);
        }
        $size = array_sum($size);
        $size = human_filesize($size);

        return [
            'title'           => $this->title,
            'slug'            => $this->slug,
            'author'          => $book->author->name,
            'books_number'    => $books_number,
            'books'           => $books,
            'cover'           => $cover,
            'download'        => $downloadLink,
            'size'            => $size,
        ];
    }
}
