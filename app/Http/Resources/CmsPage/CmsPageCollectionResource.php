<?php

namespace App\Http\Resources\CmsPage;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Model\CmsPage $resource
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
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'language' => $this->resource->language,
        ];
    }
}
