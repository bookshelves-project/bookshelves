<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookCollection extends JsonResource
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
                ...$this->resource->meta,
                'entity' => $this->resource->entity,
            ],
            'title' => $this->resource->title,
            'author' => $this->resource->meta_author,
            'cover' => $this->resource->cover,
        ];
    }
}
