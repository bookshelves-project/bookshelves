<?php

namespace App\Http\Resources\Api\Page;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Page $resource
 */
class PageCollectionResource extends JsonResource
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
            'summary' => $this->resource->summary,
            'publishedAt' => $this->resource->published_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
