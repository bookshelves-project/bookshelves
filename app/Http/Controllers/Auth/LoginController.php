<?php

namespace App\Http\Controllers\Auth;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // public function login(Request $request)
    // {
    //     // with cookie
    //     // $request->validate([
    //     //     'email' => ['required'],
    //     //     'password' => ['required']
    //     // ]);

    //     // if (Auth::attempt($request->only('email', 'password'))) {
    //     //     return response()->json(Auth::user(), 200);
    //     // }

    //     // throw ValidationException::withMessages([
    //     //     'email' => ['The provided credentials are incorrect.']
    //     // ]);

    //     // with token
    //     $request->validate([
    //         'email'       => 'required|email',
    //         'password'    => 'required',
    //         'device_name' => 'nullable',
    //     ]);

    // $user = User::where('email', $request->email)->first();

    // if (! $user || ! Hash::check($request->password, $user->password)) {
    //     throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
    // }

    //     return $user->createToken($request->device_name)->plainTextToken;
    // }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        // dump($request);
        $request->authenticate();

        $request->session()->regenerate();

        // $request->validate([
        //     'email'       => 'required|email',
        //     'password'    => 'required',
        // ]);

        // $user = User::where('email', $request->email)->first();

        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
        // }

        // return redirect(RouteServiceProvider::HOME);
        return response()->json(['success' => 'Sign in successfully']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => 'Sign out successfully']);
    }
}
