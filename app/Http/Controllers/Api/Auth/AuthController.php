<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;

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
