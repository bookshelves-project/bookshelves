<?php

namespace App\Http\Resources;

use Spatie\Tags\Tag;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Tag $resource
 */
class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'type' => $this->resource->type,
        ];
    }
}
