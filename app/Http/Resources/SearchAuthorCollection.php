<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchAuthorCollection extends JsonResource
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
                'entity' => 'author',
                'slug'   => $this->slug,
            ],
            'title'    => $this->name,
            'image'  => $this->getMedia('authors')->first()?->getUrl(),
        ];
    }
}
