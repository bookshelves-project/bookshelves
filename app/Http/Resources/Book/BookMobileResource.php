<?php

namespace App\Http\Resources\Book;

use App\Utils\BookshelvesTools;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookMobileResource extends JsonResource
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
        return [
            'id'           => $this->resource->id,
            'title'        => $this->resource->title,
            'slug'         => $this->resource->slug,
            'author'       => $this->resource->author->name,
            'summary'      => BookshelvesTools::stringLimit($this->resource->description, 140),
            'language'     => $this->resource->language?->slug,
            'publishDate'  => $this->resource->date,
            'picture'      => $this->resource->image_thumbnail ?? 'No picture',
            'publisher'    => $this->resource->publisher->name,
            'serie'        => $this->resource->serie?->title ?? 'No serie',
            'volume'       => $this->resource->volume,
            'meta'         => [
                'show'        => $this->resource->show_link,
            ],
        ];
    }
}
