<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAuthController extends Controller
{
    public function login()
    {
        return Inertia::render('auth/Login', [
            'canRegister' => config('auth.registration'),
            'status' => session('status'),
        ]);
    }

    public function requestPasswordResetLink()
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    public function resetPassword(string $token, Request $request)
    {
        return Inertia::render('auth/ResetPassword', [
            'email' => $request->query('email'),
            'token' => $token,
        ]);
    }

    public function register()
    {
        abort_if(! config('auth.registration'), 404);

        return Inertia::render('auth/Register');
    }

    public function confirmPassword()
    {
        return Inertia::render('auth/ConfirmPassword');
    }

    public function show()
    {
        return Inertia::render('profile/Show');
    }
}
