<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Service $resource
 */
class ServiceCollectionResource extends JsonResource
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
            'subtitle' => $this->resource->subtitle,
            'introduction' => $this->resource->introduction,
            'color' => $this->resource->color->name,
            'image' => $this->resource->getMediable(),
        ];
    }
}
