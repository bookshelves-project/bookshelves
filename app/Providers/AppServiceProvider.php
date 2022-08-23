<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                'Blog',
                'Créations',
                'Contenus',
                'Avancé',
            ]);
            Filament::registerTheme(
                app(Vite::class)('resources/css/filament.css'),
            );
        });
    }
}
