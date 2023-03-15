<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\TagExtend $resource
 */
class TagResource extends JsonResource
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
            ...TagCollectionResource::make($this->resource)->toArray($request),
        ];
    }
}
