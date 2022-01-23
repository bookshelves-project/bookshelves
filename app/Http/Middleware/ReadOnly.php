<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Support\Facades\Auth;

class ReadOnly
{
    private $except = [
        '*/login',
        '*/logout',
        '*/users/*/impersonate',
        '*/users/stop-impersonate',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isReadOnly($request)) {
            $message = __('Application is on read only mode.');

            session()->flash('flash.danger', $message);

            return redirect()->back()->withErrors($message);
        }

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    private function isReadOnly($request)
    {
        if (! config('app.read_only') || 'GET' === $request->method()) {
            return false;
        }

        if (Auth::check() && Auth::user()->role->equals(RoleEnum::super_admin())) {
            return false;
        }

        return ! $this->inExceptArray($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    private function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ('/' !== $except) {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
