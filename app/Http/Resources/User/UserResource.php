<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\User $resource
 */
class UserResource extends JsonResource
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
        $user = UserListResource::make($this->resource)->toArray($request);
        $meta = [
            'banner' => $this->resource->banner,
            'show_reviews' => $this->resource->show_link_reviews,
            'show_favorites' => $this->resource->show_link_favorites,
        ];
        $user['meta'] = array_merge($user['meta'], $meta);

        return $user;
    }
}
