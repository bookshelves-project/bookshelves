<?php

namespace App\Observers;

use App\Models\User;
use Hash;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        if (Hash::needsRehash($user->password)) {
            $user->password = Hash::make($user->password);
            $user->save();
        }
    }
}
