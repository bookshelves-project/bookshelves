<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Services\Auth\AuthService;

/**
 * @group User: Authentication
 */
class RegisterController extends AuthController
{
    /**
     * POST Register.
     */
    public function store(Request $request)
    {
        return AuthService::register($request);
    }
}
