<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            try {
                $mainBook = Book::whereHas('authors', function ($query) {
                    return $query->where('author_id', '=', $this->id);
                })->where('serie_number', '=', '1')->get();
            } catch (\Throwable $th) {
            }
            if (null === $mainBook) {
                $mainBook = $books->first();
            }
            try {
                $cover = $mainBook->cover->thumbnail;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        $downloadLink = config('app.url')."/api/download/author/$this->slug";
        $size = [];
        foreach ($books as $key => $book) {
            array_push($size, $book->epub?->size_bytes);
        }
        $size = array_sum($size);
        $size = human_filesize($size);

        return [
            'lastname'        => $this->lastname,
            'firstname'       => $this->firstname,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'picture'         => $this->picture ? config('app.url').'/'.$this->picture : null,
            'books_number'    => $books_number,
            'books'           => $books,
            'download'        => $downloadLink,
            'size'            => $size,
        ];
    }
}
