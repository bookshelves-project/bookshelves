<?php

namespace App\Http\Controllers\Api;

use App\Enums\GenderEnum;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\User\UserResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group User
 */
class UserController extends ApiController
{
    /**
     * GET Users list.
     */
    public function index(Request $request)
    {
        $page = $request->get('perPage') ? $request->get('perPage') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'perPage' query parameter, must be an int",
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

    /**
     * GET User details.
     */
    public function show(Request $request, string $user_slug)
    {
        $user = User::where('slug', $user_slug)->firstOrFail();

        return UserResource::make($user);
    }

    /**
     * GET Genders.
     */
    public function genders()
    {
        $genders = GenderEnum::toArray();

        return [
            'data' => $genders,
        ];
    }

    /**
     * GET User comments.
     */
    public function comments(Request $request, string $user_slug)
    {
        $user = User::whereSlug($user_slug)->firstOrFail();
        $comments = Comment::whereUserId($user->id)->get();

        return CommentResource::collection($comments);
    }

    /**
     * GET User favorites.
     */
    public function favorites(Request $request, string $user_slug)
    {
        $user = User::where('slug', $user_slug)->firstOrFail();
        $favorites = $user->favorites();

        return FavoriteResource::collection($favorites);
    }
}
