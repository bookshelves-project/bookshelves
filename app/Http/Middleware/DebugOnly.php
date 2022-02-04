<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DebugOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('app.debug')) {
            return $next($request);
        }

        return redirect()->back();
    }
}
