<?php

namespace App\Http\Resources\Admin;

use App\Models\Stub;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Stub $resource
 */
class StubResource extends JsonResource
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
