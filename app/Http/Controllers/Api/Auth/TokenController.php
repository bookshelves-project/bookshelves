<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginTokenRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

/**
 * @group Authentication
 */
class TokenController extends AuthController
{
    /**
     * POST Login.
     */
    public function authenticate(LoginTokenRequest $request)
    {
        return AuthService::token($request);
    }

    /**
     * POST Logout.
     *
     * @authenticated
     */
    public function logout(Request $request)
    {
        return AuthService::logout($request);
    }
}
