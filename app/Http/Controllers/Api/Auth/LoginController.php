<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function authenticate(Request $request)
    {
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        // }

        // return response()->json([
        //     'email' => 'The provided credentials do not match our records.',
        // ]);

        if (! Auth::attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('Email or password is not valid.');
        }

        $token = Auth::user()->createToken('user-token');

        return response()->json([
            'message' => 'Successfully logged in',
            'token' => $token->plainTextToken,
        ]);
    }

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
