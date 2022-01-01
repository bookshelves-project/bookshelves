<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestApi
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            abort(401);
        }

        return $next($request);
    }
}
