<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class IdentifierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'isbn' => $this->resource->isbn,
            'isbn10' => $this->resource->isbn10,
            'isbn13' => $this->resource->isbn13,
        ];
    }
}
