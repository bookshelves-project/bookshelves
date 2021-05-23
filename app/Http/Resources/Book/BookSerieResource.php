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
                'base'      => $this->resource->image_thumbnail,
                'openGraph' => $this->resource->image_open_graph,
                'original'  => $this->resource->image_original,
                'color'     => $this->resource->image_color,
            ],
        ]);

        return $resource;
    }
}
