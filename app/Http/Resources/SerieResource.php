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
        $language = null;

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
                    'image' => $book->image,
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
            // $book = $books->firstWhere('serie_number', 1);
        }
        // if ($book) {
        //     $language = [
        //         'slug'    => $book->language->slug,
        //         'flag'    => $book->language->flag,
        //         'display' => $book->language->display,
        //     ];
        //     try {
        //         if ($this->cover) {
        //             $cover = $this->cover ? config('app.url').'/'.$this->cover : null;
        //         } else {
        //             $cover = $book->cover->basic;
        //         }
        //     } catch (\Throwable $th) {
        //         //throw $th;
        //     }
        // }

        return [
            'title'           => $this->title,
            'slug'            => $this->slug,
            'author'          => [
                'name' => $book->author->name,
                'slug' => $book->author->slug,
            ],
            'language'        => $this->language,
            'image'                 => $this->image,
            'download'              => $this->download_link,
            'size'                  => $size,
            'books_number'    => $books_number,
            'books'           => $books,
        ];
    }
}
