<?php

namespace App\Http\Resources\Tag;

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
        $resource = TagLightResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
        ]);
    }
}
