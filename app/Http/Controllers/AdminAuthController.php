<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;

class AdminAuthController extends Controller
{
    #[Get('login', name: 'login', middleware: 'guest')]
    public function login()
    {
        return Inertia::render('auth/Login', [
            'canRegister' => config('auth.registration'),
            'status' => session('status'),
        ]);
    }

    #[Get('forgot-password', name: 'password.request', middleware: 'guest')]
    public function requestPasswordResetLink()
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    #[Get('reset-password/{token}', name: 'password.reset', middleware: 'guest')]
    public function resetPassword(string $token, Request $request)
    {
        return Inertia::render('auth/ResetPassword', [
            'email' => $request->query('email'),
            'token' => $token,
        ]);
    }

    #[Get('register', name: 'register', middleware: 'guest')]
    public function register()
    {
        abort_if(! config('auth.registration'), 404);

        return Inertia::render('auth/Register');
    }

    #[Get('user/confirm-password', name: 'password.confirm', middleware: 'auth:sanctum')]
    public function confirmPassword()
    {
        return Inertia::render('auth/ConfirmPassword');
    }

    #[Get('user/profile', name: 'profile.show', middleware: 'auth:sanctum')]
    public function show()
    {
        return Inertia::render('profile/Show');
    }
}
