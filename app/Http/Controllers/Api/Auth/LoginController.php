<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Requests\LoginRequest;

/**
 * @group User: Authentication
 */
class LoginController extends AuthController
{
    /**
     * POST Login.
     */
    public function authenticate(LoginRequest $request)
    {
        return AuthService::authenticate($request);
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
