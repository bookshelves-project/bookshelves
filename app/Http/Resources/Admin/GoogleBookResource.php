<?php

namespace App\Http\Resources\Admin;

use App\Models\GoogleBook;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property GoogleBook $resource
 */
class GoogleBookResource extends JsonResource
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
