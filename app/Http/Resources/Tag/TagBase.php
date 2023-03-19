<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\TagExtend $resource
 */
class TagBase extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meta' => [
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
                'books' => $this->resource->books_link,
            ],
            'name' => $this->resource->name,
        ];
    }
}
