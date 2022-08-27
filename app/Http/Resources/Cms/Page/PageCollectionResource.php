<?php

namespace App\Http\Resources\Cms\Page;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Cms\CmsPage $resource
 */
class PageCollectionResource extends JsonResource
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
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'language' => $this->resource->language,
        ];
    }
}
