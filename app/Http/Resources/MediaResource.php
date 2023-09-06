<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\MediaExtended $resource
 */
class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource !== null ? [
            'name' => $this->resource->file_name,
            'size' => $this->resource->size_human,
            'download' => $this->resource->download,
            'type' => $this->resource->extension,
        ] : null;
    }
}
