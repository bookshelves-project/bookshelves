<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Author\AuthorRelationResource;
use App\Http\Resources\Language\LanguageCollectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SerieCollectionResource extends JsonResource
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
            ...SerieRelationResource::make($this->resource)->toArray($request),
            'type' => $this->resource->type->locale(),
            'media' => $this->resource->cover_media,
            'language' => LanguageCollectionResource::make($this->resource->language),
            'authors' => AuthorRelationResource::collection($this->resource->authors),
            'count' => $this->resource->books_count,
        ];
    }
}
