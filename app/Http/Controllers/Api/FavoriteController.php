<?php

namespace App\Http\Controllers\Api;

use Auth;
use Route;
use App\Models\Favoritable;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCollection;

class FavoriteController extends Controller
{
    #[Route("/api/favorites/by-user/{user}", methods: ["GET"])]
    public function byUser(int $userId)
    {
        $favorites = Favoritable::whereUserId($userId)->get();

        return FavoriteCollection::collection($favorites);
    }

    #[Route("/api/favorites/toggle/{model}/{slug}", methods: ["POST"])]
    public function toggle(string $model, string $slug)
    {
        $model_name = 'App\Models\\'.ucfirst($model);
        $entity = $model_name::whereSlug($slug)->first();
        $user = Auth::user();

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
}
