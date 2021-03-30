<?php

namespace App\Http\Controllers\Api;

use Auth;
use Artisan;
use App\Http\Controllers\Controller;

class CommandController extends Controller
{
    public function updateBooks()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $books = Artisan::call('books:generate -Fs');

            return response()->json([
                'success'       => 'New eBooks are available',
                'books'         => $books,
            ]);
        }

        return response()->json(['error' => "You haven't rights to do this action"], 400);
    }
}
