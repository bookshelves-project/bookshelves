<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Spatie\RouteAttributes\RouteRegistrar;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::prefix('api')
            ->group(
                fn () => (new RouteRegistrar(app(Router::class)))
                    ->useRootNamespace(app()->getNamespace())
                    ->useMiddleware(['api'])
                    ->registerDirectory(app_path('Http/Controllers/Api'))
            );

        Route::name('front.')
            ->group(
                fn () => (new RouteRegistrar(app(Router::class)))
                    ->useRootNamespace(app()->getNamespace())
                    ->useMiddleware(['web'])
                    ->registerDirectory(app_path('Http/Controllers/Front'))
            );

        Route::prefix('catalog')
            ->group(
                fn () => (new RouteRegistrar(app(Router::class)))
                    ->useRootNamespace(app()->getNamespace())
                    ->useMiddleware(['web'])
                    ->registerDirectory(app_path('Http/Controllers/Catalog'))
            );

        Route::prefix('opds')
            ->group(
                fn () => (new RouteRegistrar(app(Router::class)))
                    ->useRootNamespace(app()->getNamespace())
                    ->useMiddleware(['web'])
                    ->registerDirectory(app_path('Http/Controllers/Opds'))
            );

        Route::prefix('webreader')
            ->group(
                fn () => (new RouteRegistrar(app(Router::class)))
                    ->useRootNamespace(app()->getNamespace())
                    ->useMiddleware(['web'])
                    ->registerDirectory(app_path('Http/Controllers/Webreader'))
            );
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
