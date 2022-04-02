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

        return [
            'title' => $serie->title,
            'type' => $this->resource->type->trans(),
            'meta' => [
                'entity' => $this->resource->getClassName(),
                'slug' => $serie->slug,
                'author' => $serie->meta_author,
                'show' => $serie->show_link,
                'books' => $serie->show_books_link,
            ],
            'cover' => [
                'thumbnail' => $serie->cover_thumbnail,
                'simple' => $serie->cover_simple,
                'color' => $this->resource->cover_color,
            ],
        ];
    }
}
