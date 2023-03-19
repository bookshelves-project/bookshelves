<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Media $resource
 */
class SpatieMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $color = $this->resource->getCustomProperty('color');

        return [
            'name' => $this->resource->getAttribute('name'),
            'url' => $this->resource->originalUrl,
            'color' => $color ? "#{$color}" : '#ffffff',
        ];
    }
}
