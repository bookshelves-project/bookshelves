<?php

namespace App\Http\Resources\Serie;

use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieUltraLightResource extends JsonResource
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
        /** @var Serie $serie */
        $serie = $this;

        $base = [
            'title' => $serie->title,
            'meta'  => [
                'slug'   => $serie->slug,
                'author' => $serie->meta_author,
                'show'   => $serie->show_link,
                'books'  => $serie->show_books_link,
            ],
            'picture' => [
                'base'   => $serie->image_thumbnail,
                'simple' => $serie->image_simple,
                'color'  => $this->resource->image_color,
            ],
        ];

        return $base;
    }
}
