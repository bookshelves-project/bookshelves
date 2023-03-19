<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author $resource
 */
class AuthorUltraLightResource extends JsonResource
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
            'meta' => [
                'entity' => $this->resource->entity,
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
            ],
        ];
    }
}
