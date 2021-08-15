<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookSerieResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        $resource = BookUltraLightResource::make($this->resource)->toArray($request);
        $resource = array_merge($resource, [
            'picture' => [
                'thumbnail'      => $this->resource->image_thumbnail,
                'og'             => $this->resource->image_og,
                'simple'         => $this->resource->image_simple,
                'original'       => $this->resource->image_original,
                'color'          => $this->resource->image_color,
            ],
        ]);

        return $resource;
    }
}
