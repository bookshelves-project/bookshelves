<?php

namespace App\Http\Resources;

use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;

class PublisherResource extends JsonResource
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
            'name'     => $publisher->name,
            'slug'     => $publisher->slug,
        ];
    }
}
