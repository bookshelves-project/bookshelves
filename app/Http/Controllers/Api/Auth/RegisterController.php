<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
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
