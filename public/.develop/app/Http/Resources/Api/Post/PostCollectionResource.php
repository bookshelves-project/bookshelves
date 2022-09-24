<?php

namespace App\Http\Resources\Api\Post;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Post $resource
 */
class PostCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->resource->title,
            'meta' => [
                'slug' => $this->resource->slug,
                'title' => $this->resource->meta_title,
                'description' => $this->resource->meta_description,
                'show' => $this->resource->show_link,
            ],
            'cover' => $this->resource->cover,
            'category' => $this->resource->category?->name,
            'user' => $this->resource->user?->name,
            'summary' => $this->resource->summary,
            'publishedAt' => $this->resource->published_at,
            'updatedAt' => $this->resource->updated_at,
            'pin' => $this->resource->pin,
        ];
    }
}
