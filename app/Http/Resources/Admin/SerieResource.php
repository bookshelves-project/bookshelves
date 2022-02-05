<?php

namespace App\Http\Resources\Admin;

use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Serie $resource
 */
class SerieResource extends JsonResource
{
    public static $wrap;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'cover' => MediaResource::collection($this->resource->getMedia('series')),
        ] + $this->resource->toArray();
    }
}
