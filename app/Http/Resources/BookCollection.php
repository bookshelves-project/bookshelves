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
                    'slug' => $author->slug,
                    'show' => $author->show_link,
                ]);
            }
        }
        $serie = null;
        if ($this->serie) {
            $serie = [
                'number'  => $this->serie_number ? $this->serie_number : null,
                'title'   => $this->serie->title,
                'slug'    => $this->serie->slug,
                'show'    => $this->serie->show_link,
            ];
        }
        $showUrl = null;
        if ($authors) {
            $showUrl = $this->show_link;
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'author'                => $this->author->slug,
            'authors'               => $authors,
            'language'              => [
                'slug' => $this->language->slug,
                'flag' => $this->language->flag,
            ],
            'picture'                 => $this->image_thumbnail,
            'serie'                   => $serie,
            'meta'                    => [
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'links'                 => [
                'show' => $showUrl,
            ],
        ];
    }
}
