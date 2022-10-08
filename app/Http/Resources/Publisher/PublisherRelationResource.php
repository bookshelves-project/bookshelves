<?php

namespace App\Http\Resources\Publisher;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Publisher $resource
 */
class PublisherRelationResource extends JsonResource
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
            'meta' => [
                ...$this->resource->meta,
                'books' => $this->resource->books_route,
            ],
            'name' => $this->resource->name,
        ];
    }
}
