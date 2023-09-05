<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Post $resource
 */
class PostCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...PostBase::make($this->resource)->toArray($request),
            'summary' => $this->resource->summary,
            'published_at' => $this->resource->published_at,
            'updated_at' => $this->resource->updated_at,
            'is_pinned' => $this->resource->is_pinned,
            'category' => $this->resource->category?->name,
            'author' => $this->resource->author?->name,
            'seo' => $this->resource->seo,
        ];
    }
}
