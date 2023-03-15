<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\SpatieMediaResource;
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
     * @param  \Illuminate\Http\Request  $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        $resource = BookUltraLightResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
            'media' => SpatieMediaResource::make($this->resource->media_primary),
        ]);
    }
}
