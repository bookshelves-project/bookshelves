<?php

namespace App\Http\Resources\Publisher;

use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;

class PublisherLightResource extends JsonResource
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
        /** @var Publisher $publisher */
        $publisher = $this;

        return [
            'name'  => $publisher->name,
            'count' => $publisher->books()->count(),
            'meta'  => [
                'slug' => $publisher->slug,
                'show' => $publisher->show_link,
            ],
        ];
    }
}
