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
        $language = null;

        if ($this->books) {
            $booksFilter = $this->books->reject(function ($book, $key) {
                return $book->serie_number < 1;
            });
            $books = $booksFilter->values();

            try {
                $id = $this->books[0]->id;
                $books = collect($books);
                $book = Book::findOrFail($id);
                $serie_slug = $this->books[0]->serie->slug;
                $serie = Serie::whereSlug($serie_slug)->firstOrFail();
                $mainBook = Book::whereSerieId($serie->id)->whereSerieNumber(1)->first();
                try {
                    $author = $mainBook->author->name;
                } catch (\Throwable $th) {
                }
            } catch (\Throwable $th) {
                return;
            }

            $books_number = count($books);

            if ($mainBook) {
                if ($mainBook->language) {
                    $language = [
                        'slug' => $mainBook->language->slug,
                        'flag' => $mainBook->language->flag,
                    ];
                }
                if ($mainBook->cover) {
                    if ($this->cover) {
                        $mainCover = $this->cover ? config('app.url').'/'.$this->cover : null;
                    } else {
                        $mainCover = $mainBook->cover->basic;
                    }
                }
            }
        }

        return [
            'title'         => $this->title,
            'slug'          => $this->slug,
            'author'        => $author,
            'language'      => $language,
            'booksNumber'   => $books_number,
            // 'cover'         => $mainCover,
            'image'                 => $this->image,
            'links'                 => [
                'show' => $this->show_link,
            ],
        ];
    }
}
