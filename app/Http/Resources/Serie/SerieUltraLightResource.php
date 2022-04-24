<?php

namespace App\Http\Resources\Serie;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SerieUltraLightResource extends JsonResource
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
            'title' => $this->resource->title,
            'type' => $this->resource->type->i18n(),
            'meta' => [
                'entity' => $this->resource->getClassName(),
                'slug' => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show' => $this->resource->show_link,
                'books' => $this->resource->books_link,
            ],
            'cover' => [
                'thumbnail' => $this->resource->cover_thumbnail,
                'simple' => $this->resource->cover_simple,
                'color' => $this->resource->cover_color,
            ],
        ];
    }
}
