<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/v1/submission',
        'api/v1/logout',
        'api/v1/login',
        'api/v1/register',
        'api/v1/password/forgot',
        'api/v1/password/reset',
    ];
}
