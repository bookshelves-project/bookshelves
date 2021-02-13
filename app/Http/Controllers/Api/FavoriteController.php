<?php

namespace App\Http\Controllers\Api;

use Auth;
use Route;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCollection;

class FavoriteController extends Controller
{
    #[Route("/api/favorites/{model}", methods: ["GET"])]
    public function index(string $model)
    {
        if (Auth::check()) {
            $model_name = 'App\Models\\'.ucfirst($model);
            $user = Auth::user();
            $entities = $model_name::whereHas('favorites', function ($query) use ($user) {
                return $query->where('user_id', '=', $user->id);
            })->get();

            return FavoriteCollection::collection($entities);
        }

        return false;
    }

    #[Route("/api/favorites/toggle/{model}/{slug}", methods: ["POST"])]
    public function toggle(string $model, string $slug)
    {
        $model_name = 'App\Models\\'.ucfirst($model);
        $entity = $model_name::whereSlug($slug)->first();
        $user = Auth::user();

        $favoriteExist = Book::find($entity->id)->favorites;
        if (sizeof($favoriteExist) < 1) {
            $entity->favorites()->save($user);
            $favoriteExist = Book::find($entity->id)->favorites;
        } else {
            $entity->favorites($user)->detach();
        }
        $userFavorites = $user->books;

        return response()->json($userFavorites);
    }
}
