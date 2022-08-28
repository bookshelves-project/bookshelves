<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author $resource
 */
class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...AuthorCollectionResource::make($this->resource)->toArray($request),
            'role' => $this->resource->role,
            'description' => $this->resource->description,
            'link' => $this->resource->link,
            'note' => $this->resource->note,
        ];
    }
}
