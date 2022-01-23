<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function redirectTo($request): string|JsonResponse
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }

        return response()->json(['error' => 'Error'], 401);
    }
}
