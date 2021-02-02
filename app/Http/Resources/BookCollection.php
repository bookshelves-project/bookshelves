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
        $author = null;
        if ($this->author) {
            $author = $this->author;
        }
        $serie = null;
        if ($this->serie) {
            $serie = [
                'number'  => $this->serie_number ? $this->serie_number : null,
                'title'   => $this->serie->title,
            ];
        }
        $cover_basic = null;
        $cover_thumbnail = null;
        if ($this->cover) {
            $cover_basic = $this->cover->basic;
            $cover_thumbnail = $this->cover->thumbnail;
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'author'                => [
                'name' => $author ? $author->name : null,
                'slug' => $author ? $author->slug : null,
            ],
            'language'              => [
                'slug' => $this->language->slug,
                'flag' => $this->language->flag,
            ],
            'cover'                 => [
                'basic'     => $cover_basic,
                'thumbnail' => $cover_thumbnail,
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
