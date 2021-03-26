<?php

namespace App\Http\Resources;

use Auth;
use App\Models\Serie;
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
                    'picture'                                => [
                        'base'                                       => $book->image_thumbnail,
                        'original'                                   => $book->image_original,
                    ],
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

        $user = Auth::user();
        $isFavorite = false;
        if ($user) {
            $entity = Serie::whereSlug($this->slug)->first();

            $checkIfFavorite = Serie::find($entity->id)->favorites;
            if (! sizeof($checkIfFavorite) < 1) {
                $isFavorite = true;
            }
        }
        $comments = null;
        if ($this->comments) {
            $comments = CommentCollection::collection($this->comments);
        }

        return [
            'title'                                  => $this->title,
            'slug'                                   => $this->slug,
            'author'                                 => $this->author->slug,
            'authors'                                => $authors,
            'language'                               => $this->language,
            'picture'                                => [
                'base'                                       => $this->image_thumbnail,
                'openGraph'                                  => $this->image_open_graph,
            ],
            'download'                               => $this->download_link,
            'size'                                   => $size,
            'books_number'                           => $books_number,
            'books'                                  => $books,
            'isFavorite'                             => $isFavorite,
            'comments'                               => $comments,
        ];
    }
}
