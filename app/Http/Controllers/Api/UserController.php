<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;

class UserController extends Controller
{
    public function auth()
    {
        return response()->json('auth');
    }

    public function toggleFavorite(string $model, string $slug)
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

    public function getFavorites(string $model)
    {
        if (Auth::check()) {
            $model_name = 'App\Models\\'.ucfirst($model);
            $user = Auth::user();
            $entities = $model_name::whereHas('favorites', function ($query) use ($user) {
                return $query->where('user_id', '=', $user->id);
            })->get();

            return BookCollection::collection($entities);
        }

        return false;
    }
}
