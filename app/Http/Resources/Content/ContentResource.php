<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Content $resource
 */
class ContentResource extends JsonResource
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
            ...ContentCollectionResource::make($this->resource)->toArray($request),
            'description' => $this->resource->description,
            'image' => $this->resource->image,
        ];
    }
}
