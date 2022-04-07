<?php

namespace App\Http\Resources\User;

use App\Enums\RoleEnum;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\User $resource
 */
class UserListResource extends JsonResource
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
        // $roles = [];
        // /** @var Role $role */
        // foreach ($this->resource->roles as $key => $role) {
        //     array_push($roles, $role->name);
        // }

        return [
            'id' => $this->resource->id,
            'meta' => [
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
            ],
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'email' => $this->resource->email,
            'role' => $this->resource->role,
            'about' => $this->resource->about,
            'gender' => $this->resource->gender,
            'avatar' => $this->resource->avatar_thumbnail,
            'color' => $this->resource->color,
            'use_gravatar' => $this->resource->use_gravatar,
            'reviews_count' => $this->resource->reviews()->count(),
            'favorites_count' => $this->resource->favorites()->count(),
            'is_admin' => $this->resource->hasRole(RoleEnum::admin),
            'display_reviews' => $this->resource->display_reviews,
            'display_favorites' => $this->resource->display_favorites,
            'display_gender' => $this->resource->display_gender,
        ];
    }
}
