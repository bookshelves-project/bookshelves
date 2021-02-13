<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchBookCollection extends JsonResource
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
        return [
            'meta' => [
                'entity' => 'book',
                'author' => $this->author->slug,
                'slug' => $this->slug
            ],
            'title'    => $this->title,
            'subtitle' => $this->serie?->title,
            'image'  => $this->getMedia('books')->first()?->getUrl(),
        ];
    }
}
