<?php

namespace App\Http\Resources;

use App\Models\MediaExtended;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MediaExtended $resource
 */
class MediaResource extends JsonResource
{
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
