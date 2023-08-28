<?php

namespace App\Http\Resources;

use App\Http\Resources\Author\AuthorBase;
use App\Http\Resources\Language\LanguageBase;
use App\Http\Resources\Serie\SerieBase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author|\App\Models\Book|\App\Models\Serie $resource
 */
class EntityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($relation = $request->header('relation')) {
            $this->resource = $this->{$relation};
        }

        return [
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'type' => $this->resource->type?->locale(),
            'authors' => AuthorBase::collection($this->resource->authors ?? []),
            'serie' => SerieBase::make($this->resource->serie),
            'language' => LanguageBase::make($this->resource->language),
            'volume' => $this->resource->volume ?? null,
            'count' => $this->resource->books_count,
            // 'media' => SpatieMediaResource::make($this->resource->media_primary),
            'media' => $this->resource->cover_media,
            'media_social' => $this->resource->cover_simple,
            'first_char' => $this->resource->first_char ?? null,
        ];
    }
}
