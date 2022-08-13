<?php

namespace App\Providers;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DestroyUserController;
use App\Http\Controllers\ImageController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Spatie\RouteAttributes\RouteRegistrar;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'))
            ;

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'))
            ;
        });

        // Auth specific actions routes...
        Route::group(['middleware' => ['web']], function () {
            Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware(['guest', 'throttle:login'])
                ->name('login')
            ;

            Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout')
            ;

            Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware(['guest'])
                ->name('password.email')
            ;

            Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware(['guest'])
                ->name('password.update')
            ;

            Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware(['guest'])
                ->name('register')
            ;

            Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
                ->middleware(['auth'])
                ->name('user-profile-information.update')
            ;

            Route::put('/user/password', [PasswordController::class, 'update'])
                ->middleware(['auth'])
                ->name('user-password.update')
            ;

            Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware(['auth'])
                ->name('password.confirm')
            ;

            Route::delete('/user', [DestroyUserController::class, 'destroy'])
                ->middleware(['auth'])
                ->name('current-user.destroy')
            ;
        });

        Route::prefix('api')
            ->name('api.')
            ->group(
                function () {
                    (new RouteRegistrar(app(Router::class)))
                        ->useRootNamespace(app()->getNamespace())
                        ->useMiddleware(['web'])
                        ->registerDirectory(app_path('Http/Controllers/Api'))
                    ;
                }
            )
        ;

        (new RouteRegistrar(app(Router::class)))
            ->useRootNamespace(app()->getNamespace())
            ->useMiddleware(['web'])
            ->registerDirectory(app_path('Http/Controllers/Front'))
        ;

        (new RouteRegistrar(app(Router::class)))
            ->useRootNamespace(app()->getNamespace())
            ->useMiddleware(['web'])
            ->registerDirectory(app_path('Http/Controllers/Webreader'))
        ;

        // Admin dedicated routes...
        Route::prefix('admin')
            ->name('admin.')
            ->group(
                function () {
                    // Admin guest auth routes...
                    (new RouteRegistrar(app(Router::class)))
                        ->useRootNamespace(app()->getNamespace())
                        ->useMiddleware(['web'])
                        ->registerClass(AdminAuthController::class)
                    ;

                    // Admin authenticated routes...
                    (new RouteRegistrar(app(Router::class)))
                        ->useRootNamespace(app()->getNamespace())
                        ->useMiddleware(['web', 'auth:sanctum', 'can:access-admin'])
                        ->registerDirectory(app_path('Http/Controllers/Admin'))
                    ;
                }
            )
        ;

        Route::get('glide/{path}', [ImageController::class, 'glide'])->where('path', '.+');
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(5000)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
