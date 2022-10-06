<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Post $resource
 */
class PostCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'picture' => $this->resource->mediable(),
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
