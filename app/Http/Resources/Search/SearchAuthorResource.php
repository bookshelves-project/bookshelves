<?php

namespace App\Http\Resources\Search;

use App\Utils\BookshelvesTools;
use Illuminate\Http\Resources\Json\JsonResource;

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
                'slug'   => $this->resource->slug,
            ],
            'title'         => $this->resource->lastname . ' ' . $this->resource->firstname,
            'author'        => $this->resource->name,
            'picture'       => $this->resource->image_thumbnail,
            'picture_og'    => $this->resource->image_open_graph,
            'color'         => $this->resource->image_color,
            'text'          => BookshelvesTools::stringLimit($this->resource->description, 140),
        ];
    }
}
