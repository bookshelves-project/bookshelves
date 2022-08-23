<?php

namespace App\Http\Resources\Service;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Service $resource
 */
class ServiceResource extends JsonResource
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
            ...ServiceCollectionResource::make($this->resource)->toArray($request),
            'hang' => $this->resource->hang,
            'title_after_purple_block' => $this->resource->title_after_purple_block,
            'cta_purple_block' => $this->resource->cta_purple_block,
            'cta' => $this->resource->cta,
            'body' => $this->resource->body,
            'image_extra' => $this->resource->getMediable('image_extra'),
            'alternate_blocks' => $this->resource->getBlocks(),
            'testimonies_blocks' => $this->resource->getBlocks('testimonies_blocks'),
            'accordion' => [
                'title' => $this->resource->accordion_title,
                'image' => $this->resource->getMediable('accordion_image'),
                'blocks' => $this->resource->accordion_blocks,
            ],
            'seo' => $this->resource->seo,
            'others' => ServiceCollectionResource::collection(
                Service::where('slug', '!=', $this->resource->slug)->get()
            ),
        ];
    }
}
