<?php

namespace App\Http\Controllers;

/**
 * @hideFromAPIDocumentation
 */
class NavigationController extends Controller
{
    public function fallback()
    {
        return response()->json([
            'failed' => 'Route not found',
        ], 404);
    }
}
