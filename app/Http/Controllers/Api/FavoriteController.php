<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FavoriteResource;
use App\Models\Favoritable;
use App\Models\User;
use Auth;
use Route;

/**
 * @group User: Account
 *
 * Endpoint to get Authors data.
 */
class FavoriteController extends ApiController
{
    // #[Route("/api/favorites/{user}", methods: ["GET"])]
    /**
     * GET Favorites by user.
     *
     * @authenticated
     */
    public function user(int $userId)
    {
        // TODO review
        // @phpstan-ignore-next-line
        $favorites = Favoritable::whereUserId($userId)
            ->with(['favoritable'])
            ->orderBy('created_at', 'DESC')
            ->get()
        ;

        return FavoriteResource::collection($favorites);
    }

    // #[Route("/api/favorites/toggle/{model}/{slug}", methods: ["POST"])]
    /**
     * POST Store new favorite.
     *
     * @authenticated
     */
    public function toggle(string $model, string $slug)
    {
        // TODO review
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

            return response()->json([
                'data' => $user->favorites,
            ]);
        }

        return response()->json(['error' => 'User not found'], 401);
    }
}
