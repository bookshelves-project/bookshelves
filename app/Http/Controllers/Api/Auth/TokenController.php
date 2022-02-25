<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Requests\LoginTokenRequest;

/**
 * @group User: Authentication
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
