<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\Comment\CommentResource;

/**
 * @group User
 */
class UserController extends ApiController
{
    /**
     * GET Users list.
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
     * GET User details.
     */
    public function show(Request $request, User $user)
    {
        return UserResource::make($user);
    }

    /**
     * GET User comments.
     */
    public function comments(Request $request, User $user)
    {
        return CommentResource::collection($user->comments);
    }

    /**
     * GET User favorites.
     */
    public function favorites(Request $request, User $user)
    {
        return FavoriteResource::collection($user->favorites);
    }
}
