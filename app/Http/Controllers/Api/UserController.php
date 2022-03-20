<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\FavoriteResource;
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
            ->with('comments')
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
     * GET Comment[] belongs to User.
     */
    public function comments(Request $request, User $user)
    {
        return CommentResource::collection($user->comments);
    }

    /**
     * GET Favorite[] belongs to User.
     */
    public function favorites(Request $request, User $user)
    {
        return FavoriteResource::collection($user->favorites);
    }
}
