<?php

namespace App\Http\Responses;

use App\Models\User;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    protected User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if ($this->user->role->equals(RoleEnum::user())) {
            return Inertia::location(route('front.home'));
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
