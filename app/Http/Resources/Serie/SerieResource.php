<?php

namespace App\Http\Resources\Serie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SerieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...SerieCollection::make($this->resource)->toArray($request),
            'description' => $this->resource->description,
            'link' => $this->resource->link,

            'download' => $this->resource->file_main,
            'files' => $this->resource->files_list,
        ];
    }
}
