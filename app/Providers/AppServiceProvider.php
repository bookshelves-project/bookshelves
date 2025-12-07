<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('bookshelves', fn () => new \App\Bookshelves);
        $this->app->bind('opds-setup', fn () => new \App\OpdsSetup);

        \Spatie\Health\Facades\Health::checks([
            \Spatie\Health\Checks\Checks\UsedDiskSpaceCheck::new(),
            \Spatie\Health\Checks\Checks\DatabaseCheck::new(),
            \Spatie\Health\Checks\Checks\HorizonCheck::new(),
            \Spatie\Health\Checks\Checks\CacheCheck::new(),
            \Spatie\Health\Checks\Checks\DebugModeCheck::new(),
            \Spatie\Health\Checks\Checks\EnvironmentCheck::new(),
            \Spatie\Health\Checks\Checks\MeilisearchCheck::new(),
            \Spatie\Health\Checks\Checks\PingCheck::new()->url(config('app.url')),
            \Spatie\Health\Checks\Checks\QueueCheck::new(),
            \Spatie\Health\Checks\Checks\RedisCheck::new(),
            \Spatie\Health\Checks\Checks\ScheduleCheck::new(),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        \Illuminate\Database\Eloquent\Model::preventLazyLoading(! $this->app->environment('production'));

        \Opcodes\LogViewer\Facades\LogViewer::auth(function (Request $request) {
            if (! $this->app->environment('production')) {
                return true;
            }

            $user = Auth::user();

            if (! $user) {
                return false;
            }

            /** @var \App\Models\User $user */
            return $user->isAdmin() || $user->isSuperAdmin();
        });

    }
}
