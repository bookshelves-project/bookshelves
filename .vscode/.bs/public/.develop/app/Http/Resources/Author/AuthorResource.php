<?php

namespace App\Http\Resources\Author;

use App\Http\Resources\Review\ReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author $resource
 */
class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(AuthorLightResource::make($this->resource)->toArray($request), [
            'meta' => [
                'entity' => $this->resource->entity,
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
                'books' => $this->resource->books_link,
                'series' => $this->resource->series_link,
                'reviews' => $this->resource->reviews_link,
            ],
            'description' => $this->resource->description,
            'link' => $this->resource->link,
            'download' => $this->resource->file_main,
            'files' => $this->resource->files_list,
            'isFavorite' => $this->resource->is_favorite,
            'reviews' => ReviewResource::collection($this->resource->reviews),
        ]);
    }
}
