<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect(route('admin.dashboard'));
        }

        return redirect(route('admin.login'));
    }

    // #[Get('login', name: 'login', middleware: 'guest')]
    public function login()
    {
        return Inertia::render('auth/LoginJetstream', [
            'canRegister' => config('auth.registration'),
            'status' => session('status'),
        ]);
    }

    // #[Get('forgot-password', name: 'password.request', middleware: 'guest')]
    public function requestPasswordResetLink()
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    // #[Get('reset-password/{token}', name: 'password.reset', middleware: 'guest')]
    public function resetPassword(string $token, Request $request)
    {
        return Inertia::render('auth/ResetPassword', [
            'email' => $request->query('email'),
            'token' => $token,
        ]);
    }

    // #[Get('register', name: 'register', middleware: 'guest')]
    public function register()
    {
        abort_if(! config('auth.registration'), 404);

        return Inertia::render('auth/Register');
    }

    // #[Get('user/confirm-password', name: 'password.confirm', middleware: 'auth:sanctum')]
    public function confirmPassword()
    {
        return Inertia::render('auth/ConfirmPassword');
    }

    // #[Get('user/profile', name: 'profile.show', middleware: 'auth:sanctum')]
    public function show()
    {
        return Inertia::render('profile/Show');
    }

    public function destroy(Request $request, StatefulGuard $auth)
    {
        $request->validate([
            'password' => 'required|string|password',
        ]);

        $request->user()->fresh()->delete();

        $auth->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function authenticate(LoginRequest $request)
    {
        AuthService::login($request);
    }
}
