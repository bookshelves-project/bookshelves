<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // $home = Auth::user()->is_admin ? config('fortify.dashboard') : config('fortify.home');

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect('dashboard');
    }
}
