<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        Filament::serving(function () {
            Filament::registerViteTheme('resources/assets/css/filament.css');
        });

        // View::addNamespace('app', resource_path());

        if ('local' !== config('app.env')) {
            LogViewer::auth(function ($request) {
                $user = $request->user();

                return $user->is_admin || $user->is_super_admin;
            });
        }
    }
}
