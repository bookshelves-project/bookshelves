<?php

namespace App\Models\Traits;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Session;

/**
 * @property null|UserRole $role
 */
trait HasImpersonate
{
    public function canImpersonate(User $user)
    {
        return $this->id !== $user->id && $this->role->equals(UserRole::super_admin, UserRole::admin) && ! $user->role->equals(UserRole::super_admin);
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
