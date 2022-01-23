<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Impersonate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('impersonate')) {
            Auth::onceUsingId($request->session()->get('impersonate'));
        }

        return $next($request);
    }
}
