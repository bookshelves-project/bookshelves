<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;
use App\Http\Controllers\Api\ApiController;

/**
 * @group User: Authentication
 */
class AuthController extends ApiController
{
    public function user()
    {
        $user = Auth::user();

        return UserResource::make($user);
    }
}
