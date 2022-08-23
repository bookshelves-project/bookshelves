<?php

namespace App\Http\Resources\TeamMember;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\TeamMember $resource
 */
class TeamMemberCollectionResource extends JsonResource
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
            'meta' => [
                'slug' => $this->resource->slug,
            ],
            'firstname' => $this->resource->firstname,
            'lastname' => $this->resource->lastname,
            'full_name' => $this->resource->full_name,
            'function' => $this->resource->function,
            'image' => $this->resource->getMediable(),
            'description' => $this->resource->description,
            'is_active' => $this->resource->is_active,
        ];
    }
}
