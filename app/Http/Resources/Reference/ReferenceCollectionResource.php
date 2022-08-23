<?php

namespace App\Http\Resources\Reference;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Reference $resource
 */
class ReferenceCollectionResource extends JsonResource
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
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'summary' => $this->resource->summary,
            'image' => $this->resource->getMediable(),
            'category' => $this->resource->category?->name,
        ];
    }
}
