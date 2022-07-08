<?php

namespace App\Http\Resources\Admin;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Author $resource
 */
class AuthorResource extends JsonResource
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
            'cover' => MediaResource::collection($this->resource->getMedia(MediaDiskEnum::cover->value)),
        ] + $this->resource->toArray();
    }
}
