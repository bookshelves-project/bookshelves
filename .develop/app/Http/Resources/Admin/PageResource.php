<?php

namespace App\Http\Resources\Admin;

use App\Models\Page;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Page $resource
 */
class PageResource extends JsonResource
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
        return [
            'featured_image' => MediaResource::collection($this->resource->getMedia('featured-image')),
        ] + $this->resource->toArray();
    }
}
