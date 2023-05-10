<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Media $resource
 */
class SpatieMediaResource extends JsonResource
{
    public function toArray($request)
    {
        $color = $this->resource->getCustomProperty('color');
        return [
            'name' => $this->resource->getAttribute('name'),
            'url' => $this->resource->originalUrl,
            'color' => $color ? "#{$color}" : '#ffffff',
        ];
    }
}