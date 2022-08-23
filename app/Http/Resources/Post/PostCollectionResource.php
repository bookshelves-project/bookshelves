<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Post $resource
 */
class PostCollectionResource extends JsonResource
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
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'subtitle' => $this->resource->subtitle,
            'summary' => $this->resource->summary,
            'is_pinned' => $this->resource->is_pinned,
            'published_at' => $this->resource->published_at,
            'image' => $this->resource->getMediable(),
        ];
    }
}
