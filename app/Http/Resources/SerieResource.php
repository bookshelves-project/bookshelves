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
            $book = $books->firstWhere('serie_number', 1);
        }
        if ($book) {
            try {
                if ($this->cover) {
                    $cover = $this->cover ? config('app.url').'/'.$this->cover : null;
                } else {
                    $cover = $book->cover->basic;
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
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
            'author'          => [
                'name' => $book->author->name,
                'slug' => $book->author->slug,
            ],
            'books_number'    => $books_number,
            'books'           => $books,
            'cover'           => $cover,
            'download'        => $downloadLink,
            'size'            => $size,
        ];
    }
}
