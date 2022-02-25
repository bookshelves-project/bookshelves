<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

class BookOrSerieResource extends JsonResource
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
        $entity = str_replace('App\Models\\', '', $this->resource::class);
        $entity = strtolower($entity);

        return [
            'meta' => [
                'entity' => $entity,
                'author' => $this->resource->meta_author,
                'slug' => $this->resource->slug,
            ],
            'title' => $this->resource->title,
            'authors' => AuthorUltraLightResource::collection($this->resource->authors),
            'volume' => $this->resource->volume ? $this->resource->volume : null,
            'cover' => [
                'thumbnail' => $this->resource->cover_thumbnail,
                'original' => $this->resource->cover_original,
                'og' => $this->resource->cover_og,
                'color' => $this->resource->cover_color,
            ],
        ];
    }
}
