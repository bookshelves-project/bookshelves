<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author $resource
 */
class AuthorCollectionResource extends JsonResource
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
            ...AuthorRelationResource::make($this->resource)->toArray($request),
            'lastname' => $this->resource->lastname,
            'firstname' => $this->resource->firstname,
            'media' => $this->resource->cover_media,
            'count' => [
                'books' => $this->resource->books_count,
                'series' => $this->resource->series_count,
            ],
        ];
    }
}
