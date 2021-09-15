<?php

namespace App\Http\Resources\User;

use App\Models\Role;
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
        $roles = [];
        /** @var Role $role */
        foreach ($this->resource->roles as $key => $role) {
            array_push($roles, $role->name);
        }

        return [
            'meta' => [
                'slug'    => $this->resource->slug,
                'show'    => $this->resource->show_link,
            ],
            'name'           => $this->resource->name,
            'slug'           => $this->resource->slug,
            'email'          => $this->resource->email,
            'avatar'         => $this->resource->avatar_thumbnail,
            'commentsCount'  => $this->resource->comments()->count(),
            'favoritesCount' => $this->resource->favorites()->count(),
            'isAdmin'        => $this->resource->hasRole(RoleEnum::ADMIN()),
            // 'roles'   => $roles,
        ];
    }
}
