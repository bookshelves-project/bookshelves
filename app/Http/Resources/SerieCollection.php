<?php

namespace App\Http\Resources;

use App\Models\Book;
use App\Models\Serie;
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
            $serie_slug = $this->books[0]->serie->slug;
            $serie = Serie::whereSlug($serie_slug)->firstOrFail();
            try {
                $mainBook = Book::whereSerieId($serie->id)->whereSerieNumber(1)->first();
                try {
                    $author = $mainBook->author->name;
                } catch (\Throwable $th) {
                }
            } catch (\Throwable $th) {
                dump($th);
            }

            $books_number = count($books);

            if ($mainBook->cover) {
                $mainCover = $mainBook->cover->basic;
                try {
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
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $otherCovers = $covers;
                array_shift($otherCovers);
            }
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
