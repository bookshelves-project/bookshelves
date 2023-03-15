<?php

namespace App\Http\Resources;

use App\Http\Resources\Author\AuthorRelationResource;
use App\Http\Resources\Language\LanguageCollectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author|\App\Models\Book|\App\Models\Serie $resource
 */
class EntityResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // if ($request->relation) {
        //     /** @var Author|Book|Serie */
        //     $this->resource = $this->{$request->relation};
        // }

        return [
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'type' => $this->resource->type->locale(),
            'authors' => AuthorRelationResource::collection($this->resource->authors ?? []),
            'serie' => $this->resource->serie?->title,
            'language' => LanguageCollectionResource::make($this->resource->language),
            'volume' => $this->resource->volume ?? null,
            'count' => $this->resource->books_count,
            // 'media' => SpatieMediaResource::make($this->resource->media_primary),
            'media' => $this->resource->cover_media,
            'media_social' => $this->resource->cover_simple,
            'first_char' => $this->resource->first_char ?? null,
        ];
    }
}
