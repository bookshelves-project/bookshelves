<?php

namespace App\Http\Resources;

use App\Http\Resources\Author\AuthorUltraLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            $className = $request->relation;
            $className = $this->resource->{$className};
            $className = get_class($className);

            $relation = $request->relation;
            $relation = $this->{$relation};
        } else {
            $className = $this->resource;
            $className = get_class($className);

            $relation = $this->resource;
        }

        $entity = str_replace('App\Models\\', '', $className);
        $entity = strtolower($entity);

        return [
            'meta' => [
                'entity' => $entity,
                'author' => $relation->meta_author ?? null,
                'slug' => $relation->slug,
                'show' => $relation->show_link,
            ],
            'title' => $relation->title ?? $relation->name,
            'authors' => $relation->authors ? AuthorUltraLightResource::collection($relation->authors) : null,
            'serie' => $relation->serie?->title,
            'language' => $relation->language?->slug,
            'volume' => $relation->volume ?? null,
            'cover' => [
                'thumbnail' => $relation->cover_thumbnail,
                'original' => $relation->cover_original,
                'simple' => $relation->cover_simple,
                'color' => $relation->cover_color,
            ],
            'first_char' => $relation->first_char,
        ];
    }
}
