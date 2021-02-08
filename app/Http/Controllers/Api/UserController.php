<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function auth()
    {
        return response()->json('auth');
    }
}
