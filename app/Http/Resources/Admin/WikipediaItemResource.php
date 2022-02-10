<?php

namespace App\Http\Resources\Admin;

use App\Models\WikipediaItem;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property WikipediaItem $resource
 */
class WikipediaItemResource extends JsonResource
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
            // 'cover' => MediaResource::collection($this->resource->getMedia('books')),
        ] + $this->resource->toArray();
    }
}
