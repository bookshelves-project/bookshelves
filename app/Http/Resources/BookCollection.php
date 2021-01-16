<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookCollection extends JsonResource
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
        $serie = null;
        $author = null;
        if ($this->author) {
            $author = $this->author;
        }
        if ($this->serie) {
            $serie = [
                'number'  => $this->serie_number ? $this->serie_number : null,
                'title'   => $this->serie->title,
            ];
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'author'                => [
                'name' => $author->name,
                'slug' => $author->slug,
            ],
            'language'              => [
                'slug' => $this->language->slug,
                'flag' => $this->language->flag,
            ],
            'cover'                 => [
                'basic'     => $this->cover ? image_cache($this->cover, 'book_cover') : null,
                'thumbnail' => $this->cover ? image_cache($this->cover, 'book_thumbnail') : null,
            ],
            'serie'                 => [
                'number' => $this->serie_number ? $this->serie_number : null,
            ],
            'serie'                 => $serie,
            'links'                 => [
                'show' => config('app.url')."/api/books/$author->slug/$this->slug",
            ],
        ];
    }
}
