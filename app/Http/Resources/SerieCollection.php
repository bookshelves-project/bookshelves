<?php

namespace App\Http\Resources;

use App\Models\Book;
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
        $books_number = null;
        $author = null;
        $covers = [];
        $mainCover = null;
        $otherCovers = null;

        if ($this->books) {
            $booksFilter = $this->books->reject(function ($book, $key) {
                return $book->serie_number < 1;
            });
            $books = $booksFilter->values();
            $id = $this->books[0]->id;
            $books = collect($books);
            $book = Book::findOrFail($id);
            $author = $book->author->name;
            // $books = BookCollection::collection($books);
            $books_number = count($books);

            // $mainCover = $book->cover->basic;
            $mainCover = $book->cover->thumbnail;

            switch (count($books)) {
                case 0:
                    break;
                case 1:
                        $covers[] = $book->cover->basic;
                    break;
                case 2:
                    foreach ($books as $key => $book) {
                        if ($key < 2) {
                            $covers[] = $book->cover->thumbnail;
                        }
                    }
                    break;
                default:
                    foreach ($books as $key => $book) {
                        if ($key < 3) {
                            $covers[] = $book->cover->thumbnail;
                        }
                    }
                    break;
            }

            // $mainCover = $covers[0];
            $otherCovers = $covers;
            array_shift($otherCovers);
        }

        return [
            'title'         => $this->title,
            'slug'          => $this->slug,
            'author'        => $author,
            'booksNumber'   => $books_number,
            'covers'        => [
                'main'  => $mainCover,
                'extra' => $otherCovers,
            ],
            'links'         => [
                'show' => config('app.url')."/api/series/$this->slug",
            ],
        ];
    }
}
