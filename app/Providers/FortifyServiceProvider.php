<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->instance(LogoutResponse::class, new class() implements LogoutResponse {
            public function toResponse($request)
            {
                if ('/api/logout' !== $request->getRequestUri()) {
                    return redirect('/admin/login');
                }

                abort(403);
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::whereEmail($request->email)->firstOrFail();
            if ('/admin/login' === $request->getRequestUri()) {
                if ($user->hasRole(RoleEnum::admin())) {
                    return $user;
                }
            } else {
                return $user;
            }
        });
        Fortify::registerView(function () {
            // return view('auth.register');
            return response()->json([
                'message' => 'Disabled',
            ], 404);
        });
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
