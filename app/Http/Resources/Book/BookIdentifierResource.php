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
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'isbn' => $this->resource->identifier_isbn,
            'isbn13' => $this->resource->identifier_isbn13,
            // 'doi' => $this->resource->identifier_doi,
            // 'amazon' => $this->resource->identifier_amazon,
            // 'google' => $this->resource->identifier_google,
        ];
    }
}
