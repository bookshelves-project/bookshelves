<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @property \App\Models\Author $resource
 */
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
                'slug' => $this->resource->slug,
            ],
            'title' => $this->resource->lastname.' '.$this->resource->firstname,
            'author' => $this->resource->name,
            'first_char' => $this->resource->first_char,
            'cover' => [
                'thumbnail' => $this->resource->cover_thumbnail,
                'og' => $this->resource->cover_og,
                'simple' => $this->resource->cover_simple,
                'color' => $this->resource->cover_color,
            ],
            'text' => Str::limit($this->resource->description, 140),
        ];
    }
}
