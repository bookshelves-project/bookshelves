<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function auth()
    {
        return response()->json('auth');
    }

    public function sanctum(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        return [
            'data'          => $user,
            'permissions'   => $user->permissions,
            'roles'         => $user->roles,
            'isAdmin'       => $user->hasRole('admin'),
        ];
    }
}
