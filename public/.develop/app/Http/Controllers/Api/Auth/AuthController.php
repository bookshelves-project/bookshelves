<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group User: Authentication
 */
#[Prefix('auth')]
class AuthController extends Controller
{
    // #[Get('/me', 'auth.me')]
    // public function me()
    // {
    //     if (Auth::check()) {
    //         return abort(401);
    //     }
    //     $user = Auth::user();

    //     return UserResource::make($user);
    // }
}
