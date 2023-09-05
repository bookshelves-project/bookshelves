<?php

namespace App\Http\Resources\Page;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Page $resource
 */
class PageBase extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'language' => $this->resource->language,
        ];
    }
}
