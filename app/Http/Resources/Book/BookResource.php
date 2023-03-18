<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...BookCollection::make($this->resource)->toArray($request),
            'meta' => [
                'entity' => $this->resource->entity,
                'slug' => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show' => $this->resource->show_link,
                // 'related' => $this->resource->related_link,
                // 'reviews' => $this->resource->reviews_link,
            ],
            'isbn' => $this->resource->isbn,
        ];
    }
}
