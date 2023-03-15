<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\TagExtend $resource
 */
class TagRelationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'meta' => [
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
                'books' => $this->resource->books_link,
            ],
            'name' => $this->resource->name,
        ];
    }
}
