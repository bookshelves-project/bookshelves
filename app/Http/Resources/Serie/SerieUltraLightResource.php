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
            'title'   => $serie->title,
            'slug'    => $serie->slug,
            'author'  => $serie->author?->slug,
            'picture' => [
                'base'  => $serie->image_thumbnail,
                'color' => $this->resource->image_color,
            ],
            'meta' => [
                'show' => $serie->show_link,
            ],
        ];

        return $base;
    }
}
