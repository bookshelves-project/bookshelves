<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        RateLimiter::for('login', function () {
            Limit::perMinute(5);
        });

        Gate::define('access-admin', function (User $auth) {
            return $auth->hasAdminAccess();
        });

        Gate::define('modify-user', function (User $auth, User $user) {
            return $auth->canUpdate($user);
        });
    }
}
