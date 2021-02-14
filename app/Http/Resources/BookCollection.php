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
        $authors = null;
        if ($this->authors) {
            $authors = [];
            foreach ($this->authors as $key => $author) {
                array_push($authors, [
                    'name' => $author->name,
                    'show' => $author->show_link
                ]);
            }
        }
        $serie = null;
        if ($this->serie) {
            $serie = [
                'number'  => $this->serie_number ? $this->serie_number : null,
                'title'   => $this->serie->title,
                'slug'    => $this->serie->slug,
                'show' => $this->serie->show_link
            ];
        }
        $cover_basic = null;
        $cover_thumbnail = null;
        if ($this->cover) {
            $cover_basic = $this->cover->basic;
            $cover_thumbnail = $this->cover->thumbnail;
        }
        $showUrl = null;
        if ($authors) {
            $showUrl = $this->show_link;
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            // 'author'                => [
            //     'name' => $author ? $author->name : null,
            //     'slug' => $author ? $author->slug : null,
            // ],
            'author'            => $this->author->slug,
            'authors'               => $authors,
            'language'              => [
                'slug' => $this->language->slug,
                'flag' => $this->language->flag,
            ],
            // 'cover'                 => [
            //     'basic'     => $cover_basic,
            //     'thumbnail' => $cover_thumbnail,
            // ],
            'image'                 => $this->getMedia('books')?->first()?->getUrl('basic'),
            'serie'                 => $serie,
            'links'                 => [
                'show' => $showUrl,
            ],
        ];
    }
}
