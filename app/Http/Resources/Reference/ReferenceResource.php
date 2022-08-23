<?php

namespace App\Http\Resources\Reference;

use App\Http\Resources\Service\ServiceCollectionResource;
use App\Models\Reference;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Reference $resource
 */
class ReferenceResource extends JsonResource
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
            ...ReferenceCollectionResource::make($this->resource)->toArray($request),
            'cta' => $this->resource->cta,
            'presentation' => [
                'title' => $this->resource->presentation_title,
                'text' => $this->resource->presentation_text,
                'year' => $this->resource->presentation_year,
            ],
            'testimony' => [
                'title' => $this->resource->testimony_title,
                'text' => $this->resource->testimony_text,
                'image' => $this->resource->getMediable('testimony_image'),
            ],
            'alternate_blocks' => $this->resource->getBlocks(),
            'seo' => $this->resource->seo,
            'services' => ServiceCollectionResource::collection($this->resource->services),
            'others' => ReferenceCollectionResource::collection(
                Reference::where('slug', '!=', $this->resource->slug)->get()
            ),
        ];
    }
}
