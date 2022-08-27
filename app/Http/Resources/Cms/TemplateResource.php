<?php

namespace App\Http\Resources\Cms;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Cms\Page $resource
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
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'language' => $this->resource->language,
            'template' => $this->resource->template_transform,
        ];
    }
}
