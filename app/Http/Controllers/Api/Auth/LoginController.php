<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

/**
 * @group Authentication
 */
class LoginController extends AuthController
{
    /**
     * POST Login.
     */
    public function authenticate(LoginRequest $request)
    {
        // AuthService::login($request);
    }

    /**
     * POST Logout.
     *
     * @authenticated
     */
    public function logout(Request $request)
    {
        AuthService::logout($request);
    }
}
