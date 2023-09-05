<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author $resource
 */
class AuthorCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...AuthorBase::make($this->resource)->toArray($request),
            'lastname' => $this->resource->lastname,
            'firstname' => $this->resource->firstname,
            'media' => $this->resource->cover_media,
            'count' => [
                'books' => $this->resource->books_count,
                'series' => $this->resource->series_count,
            ],
        ];
    }
}
