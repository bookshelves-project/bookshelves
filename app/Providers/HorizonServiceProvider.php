<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Enums\UserRoleEnum;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {

        Gate::define('viewHorizon', function (User $user) {
            try {
                $super_admin_users = User::query()
                    ->where('role', UserRoleEnum::super_admin->value)
                    ->pluck('email')
                    ->toArray();

                return in_array($user->email, $super_admin_users);
            } catch (\Throwable $th) {
                Journal::error($th);
            }

            return false;
        });
    }
}
