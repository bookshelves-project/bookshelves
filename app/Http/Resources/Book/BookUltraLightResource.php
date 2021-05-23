<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use App\Utils\BookshelvesTools;
use App\Http\Resources\PublisherResource;
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
            'title'       => $this->resource->title,
            'slug'        => $this->resource->slug,
            'author'      => $this->resource->author?->slug,
            'authors'     => AuthorUltraLightResource::collection($this->resource->authors),
            'summary'     => BookshelvesTools::stringLimit($this->resource->description, 140),
            'language'    => $this->resource->language?->slug,
            'publishDate' => $this->resource->date,
            'picture'     => [
                'base'      => $this->resource->image_thumbnail,
                'openGraph' => $this->resource->image_open_graph,
                'color'     => $this->resource->image_color,
            ],
            'publisher' => PublisherResource::make($this->resource->publisher),
            'volume'    => $this->resource->volume,
            'meta'      => [
                'show' => $this->resource->show_link,
            ],
        ];

        return $base;
    }
}
