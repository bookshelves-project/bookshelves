<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Serie\SerieBookCollectionResource;

/**
 * @property \App\Models\Book $resource
 */
class BookLightResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request)
    {
        $resource = BookUltraLightResource::make($this->resource)->toArray($request);
        $resource = array_merge($resource, [
            'serie' => SerieBookCollectionResource::make($this->resource->serie),
        ]);

        return $resource;
    }
}
