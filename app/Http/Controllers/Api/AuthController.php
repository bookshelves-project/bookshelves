<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('Email or password is not valid');
        }

        $token = Auth::user()->createToken('user-token');

        return response()->json([
            'message' => 'Successfully logged in',
            'token' => $token->plainTextToken,
        ]);
    }

    public function register(Request $request)
    {
        // $attr = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:users,email',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        // User::create([
        //     'name' => $attr['name'],
        //     'password' => Hash::make($attr['password']),
        //     'email' => $attr['email'],
        // ]);

        return response()->json([
            'message' => 'User created!',
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Tokens Revoked',
        ]);
    }
}
