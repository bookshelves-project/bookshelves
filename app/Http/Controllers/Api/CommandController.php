<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use Artisan;
use Auth;

/**
 * @hideFromAPIDocumentation
 */
class CommandController extends Controller
{
    public function updateBooks()
    {
        $user = Auth::user();

        if ($user->hasRole(RoleEnum::ADMIN())) {
            $books = Artisan::call('books:generate -Fs');

            return response()->json([
                'success' => 'New eBooks are available',
                'books' => $books,
            ]);
        }

        return response()->json(['error' => "You haven't rights to do this action"], 400);
    }
}
