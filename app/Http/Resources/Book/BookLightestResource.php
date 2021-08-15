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
            'title' => $this->resource->title,
            'meta'  => [
                'slug'   => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show'   => $this->resource->show_link,
            ],
            'picture' => [
                'thumbnail'  => $this->resource->image_thumbnail,
                'color'      => $this->resource->image_color,
            ],
            'serie' => $this->resource->serie?->title,
        ];
    }
}
