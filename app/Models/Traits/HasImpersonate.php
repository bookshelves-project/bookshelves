<?php

namespace App\Models\Traits;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Session;

/**
 * @property null|RoleEnum $role
 */
trait HasImpersonate
{
    public function canImpersonate(User $user)
    {
        return $this->id !== $user->id && $this->role->equals(RoleEnum::super_admin(), RoleEnum::admin()) && ! $user->role->equals(RoleEnum::super_admin());
    }

    public function setImpersonating($id)
    {
        Session::put('impersonate', $id);
    }

    public function stopImpersonating()
    {
        Session::forget('impersonate');
    }

    public function isImpersonating()
    {
        return Session::has('impersonate');
    }
}
