<?php

namespace App\Services\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public static function login(LoginRequest $request)
    {
        $response = [
            'message' => 'Email or password is not valid.',
        ];
        $status = 401;

        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $token = Auth::user()->createToken('front-token');
            $response = [
                'message' => 'Successfully logged in',
                'token' => $token->plainTextToken,
            ];
            $status = 200;
        }

        return response()->json([
            'message' => $request,
        ], 401);
    }

    public static function logout(Request $request)
    {
        $user = Auth::user();
        $user->remember_token = null;
        $user->save();

        Auth::user()->tokens()->delete();

        // Auth::guard('front')->logout();
        // auth('front')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Tokens Revoked',
        ]);
    }

    public static function register(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $name = $validate['email'];
        $name = explode('@', $name);
        User::create([
            'name' => $name[0],
            'password' => Hash::make($validate['password']),
            'email' => $validate['email'],
        ]);

        return response()->json([
            'message' => 'User created!',
        ]);
    }
}
