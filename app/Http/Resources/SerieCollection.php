<?php

namespace App\Http\Resources;

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
        $language = null;
        $size = null;
        $books_number = null;

        if ($this->books) {
            $booksFilter = $this->books->reject(function ($book, $key) {
                return $book->serie_number < 1;
            });
            $books = $booksFilter->values();

            $books_number = count($books);
        }

        $authors = null;
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
            'title'                  => $this->title,
            'slug'                   => $this->slug,
            'authors'                => $authors,
            'language'               => $language,
            'booksNumber'            => $books_number,
            'image'                  => $this->image_thumbnail,
            'links'                  => [
                'show' => $this->show_link,
            ],
        ];
    }
}
