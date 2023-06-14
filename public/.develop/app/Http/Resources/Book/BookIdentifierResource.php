<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookIdentifierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'isbn' => $this->resource->isbn,
            'isbn10' => $this->resource->isbn10,
            'isbn13' => $this->resource->isbn13,
        ];
    }
}
