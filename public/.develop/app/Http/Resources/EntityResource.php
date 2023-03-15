<?php

namespace App\Http\Resources;

use App\Class\Entity;
use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Http\Resources\Language\LanguageLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Class\Entity $resource
 */
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
        if ($request->relation) {
            $this->resource = $this->{$request->relation};
        }

        return [
            'meta' => [
                'entity' => Entity::getEntity($this->resource),
                'author' => $this->resource->meta_author,
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
            ],
            'title' => $this->resource->title ?? $this->resource->name,
            'type' => $this->resource->type?->i18n(),
            'authors' => $this->resource->authors ? AuthorUltraLightResource::collection($this->resource->authors) : null,
            'serie' => $this->resource->serie?->title,
            'language' => LanguageLightResource::make($this->resource->language),
            'volume' => $this->resource->volume ?? null,
            'count' => $this->resource->books_count,
            'media' => SpatieMediaResource::make($this->resource->media_primary),
            'media_social' => $this->resource->cover_simple,
            'first_char' => $this->resource->first_char,
        ];
    }
}
