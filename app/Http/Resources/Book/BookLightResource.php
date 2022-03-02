<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Serie\SerieUltraLightResource;
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
        return array_merge(BookUltraLightResource::make($this->resource)->toArray($request), [
            'serie' => SerieUltraLightResource::make($this->resource->serie),
        ]);

        // return [
        //     'title' => $this->resource->title,
        //     'authors' => $this->resource->authors_names,
        //     'show' => $this->resource->show_link,
        //     'cover' => $this->resource->cover_thumbnail,
        //     'serie' => $this->resource->serie?->title,
        //     'volume' => $this->resource->volume,
        // ];
    }
}
