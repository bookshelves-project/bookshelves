<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FavoriteResource;
use App\Http\Resources\Review\ReviewResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group User: Profile
 */
class UserController extends ApiController
{
    /**
     * GET User[].
     */
    public function index()
    {
        $users = User::orderBy('name')
            ->with('reviews')
            ->get()
        ;

        return UserListResource::collection($users);
    }

    /**
     * GET User.
     */
    public function show(Request $request, User $user)
    {
        return UserResource::make($user);
    }

    /**
     * GET Review[] belongs to User.
     */
    public function reviews(Request $request, User $user)
    {
        return ReviewResource::collection($user->reviews);
    }

    /**
     * GET Favorite[] belongs to User.
     */
    public function favorites(Request $request, User $user)
    {
        return FavoriteResource::collection($user->favorites);
    }
}
