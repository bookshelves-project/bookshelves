<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favoritable;
use App\Models\User;
use Auth;
use Route;

/**
 * @hideFromAPIDocumentation
 */
class FavoriteController extends Controller
{
    // #[Route("/api/favorites/{user}", methods: ["GET"])]
    public function user(int $userId)
    {
        $favorites = Favoritable::whereUserId($userId)->with([
            'favoritable',
        ])->orderBy('created_at', 'DESC')->get();

        return FavoriteResource::collection($favorites);
    }

    // #[Route("/api/favorites/toggle/{model}/{slug}", methods: ["POST"])]
    public function toggle(string $model, string $slug)
    {
        if (Auth::check()) {
            $model_name = 'App\Models\\'.ucfirst($model);
            $entity = $model_name::whereSlug($slug)->first();
            $user = Auth::id();
            $user = User::find($user);

            $favoriteExist = $model_name::find($entity->id)->favorites;
            if (sizeof($favoriteExist) < 1) {
                $entity->favorites()->save($user);
                $favoriteExist = $model_name::find($entity->id)->favorites;
            } else {
                $entity->favorites($user)->detach();
            }
            $userFavorites = $user->books;

            return response()->json($userFavorites);
        }

        return response()->json(['error' => 'User not found'], 401);
    }
}
