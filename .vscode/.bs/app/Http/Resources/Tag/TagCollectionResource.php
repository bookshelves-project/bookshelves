<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\TagExtend $resource
 */
class TagCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...TagRelationResource::make($this->resource)->toArray($request),
            'type' => $this->resource->type,
            'count' => $this->resource->books_count,
            'first_char' => $this->resource->first_char,
        ];
    }
}
