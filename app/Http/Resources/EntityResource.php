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
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'type' => $this->resource->type?->locale(),
            'authors' => $this->toAuthors(),
            'serie' => $this->toSerie(),
            'language' => $this->toLanguage(),
            'volume' => $this->resource->volume ?? null,
            'count' => $this->resource->books_count,
            'media' => $this->resource->cover_thumbnail,
            // 'first_char' => $this->resource->first_char ?? null,
        ];
    }

    private function toAuthors(): array
    {
        return $this->resource->authors->map(fn ($author) => [
            'id' => $author->id,
            'name' => $author->name,
            'slug' => $author->slug,
            'first_char' => $author->first_char,
        ])->toArray();
    }

    private function toSerie(): array
    {
        return [
            'id' => $this->resource->serie->id,
            'name' => $this->resource->serie->title,
            'slug' => $this->resource->serie->slug,
            'first_char' => $this->resource->serie->first_char,
        ];
    }

    private function toLanguage(): array
    {
        return [
            'name' => $this->resource->language->name,
            'slug' => $this->resource->language->slug,
        ];
    }
}
