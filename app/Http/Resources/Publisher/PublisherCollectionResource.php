<?php

namespace App\Http\Resources\Publisher;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Publisher $resource
 */
class PublisherCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...PublisherRelationResource::make($this->resource)->toArray($request),
            'count' => $this->resource->books_count,
            'firstChar' => $this->resource->first_char,
        ];
    }
}
