<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

class EntityResource extends JsonResource
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
                'author' => $this->resource->meta_author ?? null,
                'slug'   => $this->resource->slug,
                'show'   => $this->resource->show_link,
            ],
            'title'    => $this->resource->title ?? $this->resource->name,
            'authors'  => $this->resource->authors ? AuthorUltraLightResource::collection($this->resource->authors) : null,
            'serie'    => $this->resource->serie?->title,
            'language' => $this->resource->language?->slug,
            'volume'   => $this->resource->volume ?? null,
            'picture'  => [
                'base'     => $this->resource->image_thumbnail,
                'original' => $this->resource->image_original,
                'simple'   => $this->resource->image_simple,
                'color'    => $this->resource->image_color,
            ],
        ];
    }
}
