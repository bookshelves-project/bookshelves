<?php

namespace App\Http\Resources\Publisher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Publisher $resource
 */
class PublisherCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...PublisherBase::make($this->resource)->toArray($request),
            'count' => $this->resource->books_count,
            'firstChar' => $this->resource->first_char,
        ];
    }
}
