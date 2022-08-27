<?php

namespace App\Http\Resources\Cms\Page;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Cms\CmsPage $resource
 */
class PageResource extends JsonResource
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
            ...PageCollectionResource::make($this->resource)->toArray($request),
            'content' => $this->resource->page_transform,
        ];
    }
}
