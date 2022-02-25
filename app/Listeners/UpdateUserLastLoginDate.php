<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Carbon;

class UpdateUserLastLoginDate
{
    public function handle(Login $event)
    {
        /** @var User $user */
        $user = $event->user;

        $user->last_login_at = Carbon::now();
        $user->save();
    }
}
