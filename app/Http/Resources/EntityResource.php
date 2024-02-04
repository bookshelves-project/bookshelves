<?php

namespace App\Http\Resources;

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
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'type' => $this->resource->type?->locale(),
            'authors' => $this->toAuthors(),
            'serie' => $this->toSerie(),
            'language' => $this->toLanguage(),
            'volume' => $this->resource->volume ?? null,
            'count' => $this->resource->books_count,
            'cover_thumbnail' => $this->resource->cover_thumbnail,
            'cover_color' => $this->resource->cover_color,
            'meta_route' => $this->resource->meta_route,
            // 'first_char' => $this->resource->first_char ?? null,
        ];
    }

    private function toAuthors(): ?array
    {
        if ($this->resource->authors->isEmpty()) {
            return null;
        }

        return $this->resource->authors->map(fn ($author) => [
            'id' => $author->id,
            'name' => $author->name,
            'slug' => $author->slug,
            'first_char' => $author->first_char,
        ])->toArray();
    }

    private function toSerie(): ?array
    {
        if (! $this->resource->serie) {
            return null;
        }

        return [
            'id' => $this->resource->serie->id,
            'name' => $this->resource->serie->title,
            'slug' => $this->resource->serie->slug,
            'first_char' => $this->resource->serie->first_char,
        ];
    }

    private function toLanguage(): ?array
    {
        if (! $this->resource->language) {
            return null;
        }

        return [
            'name' => $this->resource->language->name,
            'slug' => $this->resource->language->slug,
        ];
    }
}
