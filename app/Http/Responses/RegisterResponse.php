<?php

namespace App\Http\Responses;

use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if (Auth::user()->role->equals(RoleEnum::user())) {
            return Inertia::location(route('front.home'));
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
