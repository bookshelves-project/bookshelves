<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\SpatieMediaResource;
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
                'entity' => $this->resource->entity,
                'slug' => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show' => $this->resource->show_link,
                'books' => $this->resource->books_link,
            ],
            'media' => SpatieMediaResource::make($this->resource->media_primary),
            'media_social' => $this->resource->cover_simple,
        ];
    }
}
