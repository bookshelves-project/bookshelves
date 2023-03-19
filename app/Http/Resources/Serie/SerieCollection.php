<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Author\AuthorBase;
use App\Http\Resources\Language\LanguageBase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SerieCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...SerieBase::make($this->resource)->toArray($request),
            'type' => $this->resource->type->locale(),
            'media' => $this->resource->cover_media,
            'language' => LanguageBase::make($this->resource->language),
            'authors' => AuthorBase::collection($this->resource->authors),
            'count' => $this->resource->books_count,
        ];
    }
}
