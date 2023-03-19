<?php

namespace App\Http\Resources\Publisher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Publisher $resource
 */
class PublisherBase extends JsonResource
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
                'books' => $this->resource->books_route,
            ],
            'name' => $this->resource->name,
        ];
    }
}
