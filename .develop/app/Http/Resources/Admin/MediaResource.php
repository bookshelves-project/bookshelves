<?php

namespace App\Http\Resources\Admin;

use App\Models\MediaExtended;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MediaExtended $resource
 */
class MediaResource extends JsonResource
{
    public static $wrap;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->only('uuid', 'name', 'custom_properties', 'size') + [
            'order' => $this->resource->order_column,
            'url' => $this->resource->getFullUrl(),
            'preview_url' => $this->resource->glide(['w' => 300, 'h' => 300, 'fit' => 'crop'])->getUrl(),
            'original_url' => $this->resource->getUrl(),
            'extension' => $this->resource->full_extension,
        ];
    }
}
