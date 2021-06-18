<?php

namespace App\Http\Resources\Serie;

use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieBookCollectionResource extends JsonResource
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
            ],
        ];

        return $base;
    }
}
