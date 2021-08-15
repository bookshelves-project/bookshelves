<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use App\Utils\BookshelvesTools;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

/**
 * @property \App\Models\Book $resource
 */
class BookUltraLightResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        $base = [
            'title' => $this->resource->title,
            'meta'  => [
                'slug'   => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show'   => $this->resource->show_link,
            ],
            'authors'     => AuthorUltraLightResource::collection($this->resource->authors),
            'summary'     => BookshelvesTools::stringLimit($this->resource->description, 140),
            'language'    => $this->resource->language?->slug,
            'publishDate' => $this->resource->date,
            'picture'     => [
                'thumbnail'   => $this->resource->image_thumbnail,
                'simple'      => $this->resource->image_simple,
                'color'       => $this->resource->image_color,
            ],
            'volume' => $this->resource->volume,
        ];

        return $base;
    }
}
