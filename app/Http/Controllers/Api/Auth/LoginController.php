<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginTokenRequest;
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
    public function session(LoginRequest $request)
    {
        AuthService::loginSession($request);
    }

    public function token(LoginTokenRequest $request)
    {
        AuthService::loginToken($request);
    }

    /**
     * POST Logout.
     *
     * @authenticated
     */
    public function logoutSession(Request $request)
    {
        AuthService::logoutSession($request);
    }

    public function logoutToken(Request $request)
    {
        AuthService::logoutToken($request);
    }
}
