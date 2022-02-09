<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Serie\SerieBookCollectionResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return BookUltraLightResource::make($this->resource)->toArray($request) + [
            'serie' => SerieBookCollectionResource::make($this->resource->serie),
        ];
    }
}
