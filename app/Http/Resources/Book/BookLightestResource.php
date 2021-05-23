<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookLightestResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        return [
            'title'  => $this->resource->title,
            'slug'   => $this->resource->slug,
            'author' => $this->resource->author?->slug,
            'serie'  => $this->resource->serie?->title,
            'meta'   => [
                'show' => $this->resource->show_link,
            ],
        ];
    }
}
