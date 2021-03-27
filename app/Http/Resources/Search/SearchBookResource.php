<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchBookResource extends JsonResource
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
        $serie = null;
        if ($this->serie) {
            $serie = [
                'title'  => $this->serie->title,
                'number' => $this->serie_number,
            ];
        }

        return [
            'meta' => [
                'entity' => 'book',
                'author' => $this->author->slug,
                'slug'   => $this->slug,
            ],
            'title'      => $this->title,
            'subtitle'   => $this->serie?->title,
            'author'     => $this->author->name,
            'serie'      => $serie,
            'picture'    => $this->image_thumbnail,
        ];
    }
}
