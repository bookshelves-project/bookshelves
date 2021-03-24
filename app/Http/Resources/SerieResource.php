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
        $book = null;
        $size = null;
        $books_number = 0;
        $authors = null;
        if ($this->books) {
            $size = [];
            $books = [];
            foreach ($this->books as $key => $book) {
                $authors = [];
                foreach ($book->authors as $key => $author) {
                    array_push($authors, [
                        'name' => $author->name,
                        'show' => $author->show_link,
                    ]);
                }
                array_push($books, [
                    'title'    => $book->title,
                    'slug'     => $book->slug,
                    'author'   => $book->author->slug,
                    'authors'  => $authors,
                    'language' => [
                        'slug' => $book->language->slug,
                        'flag' => $book->language->flag,
                    ],
                    'image' => $book->image_thumbnail,
                    'serie' => [
                        'number' => $book->serie_number,
                    ],
                    'links' => [
                        'show' => $book->show_link,
                    ],
                ]);
                array_push($size, $book->getMedia('books_epubs')->first()?->size);
            }
            $books_number = sizeof($books);
            $size = array_sum($size);
            $size = human_filesize($size);
        }

        if ($this->authors) {
            $authors = [];
            foreach ($this->authors as $key => $author) {
                array_push($authors, [
                    'name' => $author->name,
                    'slug' => $author->slug,
                    'show' => $author->show_link,
                ]);
            }
        }

        return [
            'title'                                  => $this->title,
            'slug'                                   => $this->slug,
            'author'                                 => $this->author->slug,
            'authors'                                => $authors,
            'language'                               => $this->language,
            'image'                                  => $this->image_thumbnail,
            'imageOpenGraph'                         => $this->image_open_graph,
            'download'                               => $this->download_link,
            'size'                                   => $size,
            'books_number'                           => $books_number,
            'books'                                  => $books,
        ];
    }
}
