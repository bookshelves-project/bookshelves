<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('bookshelves', fn () => new \App\Bookshelves());
        $this->app->bind('opds-base', fn () => new \App\OpdsBase());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Database\Eloquent\Model::preventLazyLoading(! $this->app->environment('production'));

        \Opcodes\LogViewer\Facades\LogViewer::auth(function (Request $request) {
            if (! $this->app->environment('production')) {
                return true;
            }

            $user = Auth::user();

            if (! $user) {
                return false;
            }

            /** @var User $user */
            return $user->isAdmin() || $user->isSuperAdmin();
        });
    }
}
