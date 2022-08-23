<?php

namespace App\Http\Resources\ReferenceCategory;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property \App\Models\ReferenceCategory $resource
 */
class ReferenceCategoryCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
        ];
    }
}
