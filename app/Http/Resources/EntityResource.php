<?php

namespace App\Http\Resources;

use App\Models\Entity;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Entity $resource
 */
class EntityResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'entity' => Entity::getEntity($this->resource),
            'slug' => $this->resource->slug,
            'title' => $this->resource->title,
            // 'media' => MediaResource::make($this->resource->media_primary),
        ];
    }
}
