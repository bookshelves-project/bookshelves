<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchAuthorResource extends JsonResource
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
            'title'      => $this->lastname.' '.$this->firstname,
            'author'     => $this->name,
            'picture'    => $this->image_thumbnail,
        ];
    }
}
