<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Tags\Tag;

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
        $resource = TagLightResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
        ]);
    }
}
