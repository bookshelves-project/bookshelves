<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\TagExtend $resource
 */
class TagCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...TagBase::make($this->resource)->toArray($request),
            'type' => $this->resource->type,
            'count' => $this->resource->books_count,
            'firstChar' => $this->resource->first_char,
        ];
    }
}
