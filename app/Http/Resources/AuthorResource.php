<?php

namespace App\Http\Resources;

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
        $size = null;
        $books_number = null;
        $series = null;
        if ($this->series) {
            $series = [];
            foreach ($this->series as $key => $serie) {
                if ($serie->books) {
                    $booksFilter = $serie->books->reject(function ($book, $key) {
                        return $book->serie_number < 1;
                    });
                    $books = $booksFilter->values();

                    $books_number = count($books);
                }
                array_push($series, [
                    'title'            => $serie->title,
                    'slug'             => $serie->slug,
                    'picture'          => $serie->image_thumbnail,
                    'bookNumber'       => $books_number,
                    'show'             => $serie->show_link,
                ]);
            }
        }
        if ($this->books) {
            $books = [];
            $size = [];
            foreach ($this->books as $key => $book) {
                array_push($books, [
                    'title'    => $book->title,
                    'slug'     => $book->slug,
                    'author'   => $book->author->slug,
                    'language' => [
                        'slug' => $book->language->slug,
                        'flag' => $book->language->flag,
                    ],
                    'picture' => $book->image_thumbnail,
                    'serie'   => $book->serie ? [
                        'number' => $book->serie_number,
                        'title'  => $book->serie->title,
                        'show'   => $book->serie->show_link,
                    ] : null,
                    'show' => $book->show_link,
                ]);
                array_push($size, $book->getMedia('books_epubs')->first()?->size);
            }
            $books_number = sizeof($books);
            $size = array_sum($size);
            $size = human_filesize($size);
        }

        return [
            'lastname'                               => $this->lastname,
            'firstname'                              => $this->firstname,
            'name'                                   => $this->name,
            'slug'                                   => $this->slug,
            'picture'                                => [
                'base'                                  => $this->image_thumbnail,
                'openGraph'                             => $this->image_open_graph,
            ],
            'download'                               => $this->download_link,
            'size'                                   => $size,
            'books_number'                           => $books_number,
            'series'                                 => $series,
            'books'                                  => $books,
        ];
    }
}
