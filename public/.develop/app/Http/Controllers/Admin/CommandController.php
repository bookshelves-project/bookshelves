<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
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

        if ($user->hasRole(UserRole::admin)) {
            $books = Artisan::call('books:generate -Fs');

            return response()->json([
                'success' => 'New books are available',
                'books' => $books,
            ]);
        }

        return response()->json(['error' => "You haven't rights to do this action"], 400);
    }
}
