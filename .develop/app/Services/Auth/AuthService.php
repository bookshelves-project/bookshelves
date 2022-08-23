<?php

namespace App\Services\Auth;

use App\Enums\RoleEnum;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginTokenRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public static function authenticate(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! auth('user')->attempt($credentials, $request->remember)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials',
            ]);
        }

        $request->session()->regenerate();

        return response()->json(null, 201);
    }

    public static function token(LoginTokenRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            // @var User $user
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public static function logout(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->tokens()->delete();

        // auth('user')->guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(null, 200);
    }

    public static function register(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $name = $validate['email'];
        $name = explode('@', $name);
        $user = User::create([
            'name' => $name[0],
            'password' => Hash::make($validate['password']),
            'email' => $validate['email'],
            'role' => RoleEnum::user->name,
        ]);

        return UserResource::make($user);
    }
}
