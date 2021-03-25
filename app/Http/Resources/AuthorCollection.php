<?php

namespace App\Http\Resources;

use App\Models\Book;
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
        $books_number = null;
        if ($this->books) {
            $books = BookCollection::collection($this->books);
            $books_number = sizeof($books);
            // $book = $books->random();

            $mainBook = null;
            try {
                $mainBook = Book::with('authors')->where('serie_number', '=', '1')->whereAuthorId($this->id)->first();
            } catch (\Throwable $th) {
            }
            if ($mainBook) {
                $mainBook = $books->first();
            }
            try {
                $cover = $mainBook->cover->thumbnail;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        return [
            'lastname'                => $this->lastname,
            'firstname'               => $this->firstname,
            'name'                    => $this->name,
            'slug'                    => $this->slug,
            'books_number'            => $books_number,
            'picture'                 => $this->image_thumbnail,
            'links'                   => [
                'show' => config('app.url')."/api/authors/$this->slug",
            ],
        ];
    }
}
