<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorBase extends JsonResource
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
                'books' => $this->resource->books_link,
                'series' => $this->resource->series_link,
            ],
            'name' => $this->resource->name,
        ];
    }
}
