<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorRelationResource;
use App\Http\Resources\Language\LanguageCollectionResource;
use App\Http\Resources\Serie\SerieRelationResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...BookRelationResource::make($this->resource)->toArray($request),
            'media' => $this->resource->cover_media,
            'type' => $this->resource->type->locale(),
            'volume' => $this->resource->volume,
            'language' => LanguageCollectionResource::make($this->resource->language),
            'authors' => AuthorRelationResource::collection($this->resource->authors),
            'serie' => SerieRelationResource::make($this->resource->serie),
        ];
    }
}
