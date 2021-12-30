<?php

namespace App\Http\Resources\User;

use App\Enums\RoleEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

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
            'about' => $this->resource->about,
            'gender' => $this->resource->gender->value,
            'avatar' => $this->resource->avatar_thumbnail,
            'use_gravatar' => $this->resource->use_gravatar,
            'comments_count' => $this->resource->comments()->count(),
            'favorites_count' => $this->resource->favorites()->count(),
            // 'is_admin' => $this->resource->hasRole(RoleEnum::admin()),
            'display_comments' => $this->resource->display_comments,
            'display_favorites' => $this->resource->display_favorites,
            'display_gender' => $this->resource->display_gender,
        ];
    }
}
