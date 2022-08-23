<?php

namespace App\Http\Resources\Admin;

use App\Models\TagExtend;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TagExtend $resource
 */
class TagResource extends JsonResource
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
            'name' => $this->resource->name,
            'type' => $this->resource->type,
        ] + $this->resource->toArray();
    }
}
