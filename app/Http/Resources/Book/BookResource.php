<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...BookCollectionResource::make($this->resource)->toArray($request),
            'contributor' => $this->resource->contributor,
            'description' => $this->resource->description,
            'released_on' => $this->resource->released_on,
            'rights' => $this->resource->rights,
            'page_count' => $this->resource->page_count,
            'maturity_rating' => $this->resource->maturity_rating,
            'isbn' => $this->resource->isbn,
        ];
    }
}
