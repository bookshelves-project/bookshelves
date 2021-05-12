<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SearchSerieResource extends JsonResource
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
                'entity'   => 'serie',
                'author'   => $this->resource->author->slug,
                'slug'     => $this->resource->slug,
            ],
            'title'         => $this->resource->title,
            'author'        => $this->resource->books[0]->author->name,
            'picture'       => $this->resource->image_thumbnail,
            'picture_og'    => $this->resource->image_open_graph,
        ];
    }
}
