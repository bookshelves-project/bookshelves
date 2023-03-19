<?php

namespace App\Http\Responses;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if (Auth::user()->role->equals(UserRole::user)) {
            return Inertia::location(route('front.home'));
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
