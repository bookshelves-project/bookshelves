<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author $resource
 */
class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...AuthorCollection::make($this->resource)->toArray($request),
            'role' => $this->resource->role,
            'description' => $this->resource->description,
            'link' => $this->resource->link,
            'note' => $this->resource->note,
        ];
    }
}
