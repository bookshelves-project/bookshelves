<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Http\Resources\Json\JsonResource;

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
        /** @var User $user */
        $user = $this;

        $roles = [];
        /** @var Role $role */
        foreach ($user->roles as $key => $role) {
            array_push($roles, $role->name);
        }

        return [
            'name'    => $user->name,
            'email'   => $user->email,
            'avatar'  => $user->avatar,
            'isAdmin' => $user->hasRole(RoleEnum::ADMIN()),
            'roles'   => $roles,
        ];
    }
}
