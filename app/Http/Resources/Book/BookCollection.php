<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorBase;
use App\Http\Resources\Language\LanguageBase;
use App\Http\Resources\Serie\SerieBase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...BookBase::make($this->resource)->toArray($request),
            'media' => $this->resource->cover_media,
            'type' => $this->resource->type->locale(),
            'volume' => $this->resource->volume,
            'language' => LanguageBase::make($this->resource->language),
            'authors' => AuthorBase::collection($this->resource->authors),
            'serie' => SerieBase::make($this->resource->serie),
        ];
    }
}
