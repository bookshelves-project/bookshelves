<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserListResource;

/**
 * @hideFromAPIDocumentation
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('per-page') ? $request->get('per-page') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);
        $users = User::orderBy('name')->with('comments');
        if ($page) {
            $users = $users->paginate($page);
        } else {
            $users = $users->get();
        }

        return UserListResource::collection($users);
    }

    public function show(Request $request, string $user_slug)
    {
        $user = User::where('slug', $user_slug)->firstOrFail();

        return UserResource::make($user);
    }

    public function comments(Request $request, string $user_slug)
    {
        $user = User::where('slug', $user_slug)->with('comments')->firstOrFail();
        $comments = $user->comments;

        return CommentResource::collection($comments);
    }

    public function favorites(Request $request, string $user_slug)
    {
        $user = User::where('slug', $user_slug)->firstOrFail();
        $favorites = $user->favorites();

        return FavoriteResource::collection($favorites);
    }
}
