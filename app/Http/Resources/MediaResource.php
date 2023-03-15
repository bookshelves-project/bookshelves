<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\MediaExtended $resource
 */
class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return null !== $this->resource ? [
            'name' => $this->resource->file_name,
            'size' => $this->resource->size_human,
            'download' => $this->resource->download,
            'type' => $this->resource->extension,
        ] : null;
    }
}
