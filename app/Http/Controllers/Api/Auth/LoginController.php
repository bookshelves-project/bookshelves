<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (! Auth::attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('Email or password is not valid.');
        }

        $token = Auth::user()->createToken('front-token');

        return response()->json([
            'message' => 'Successfully logged in',
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * POST Logout.
     *
     * @authenticated
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Tokens Revoked',
        ]);
    }
}
