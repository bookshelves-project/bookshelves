<?php

namespace App\Http\Resources\Admin;

use App\Enums\MediaDiskEnum;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Book $resource
 */
class BookResource extends JsonResource
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
            'cover' => MediaResource::collection($this->resource->getMedia(MediaDiskEnum::cover->value)),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ] + $this->resource->toArray();
    }
}
