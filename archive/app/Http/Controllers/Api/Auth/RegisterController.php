<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

/**
 * @group Authentication
 */
class RegisterController extends AuthController
{
    /**
     * POST Register.
     */
    public function store(Request $request)
    {
        AuthService::register($request);
    }
}
