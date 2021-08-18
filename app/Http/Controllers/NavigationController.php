<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;

/**
 * @hideFromAPIDocumentation
 */
class NavigationController extends Controller
{
    public function welcome()
    {
        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;

        return view('pages/welcome', compact('laravelVersion', 'phpVersion'));
    }

    public function fallback()
    {
        return response()->json([
            'failed' => 'Route not found'
        ], 404);
    }
}
