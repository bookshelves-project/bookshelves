<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;
use View;

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
        View::addNamespace('front', resource_path('front'));
        View::addNamespace('catalog', resource_path('catalog'));
        View::addNamespace('webreader', resource_path('webreader'));

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                'Books',
            ]);
            Filament::registerTheme(
                app(Vite::class)('resources/admin/filament.css'),
            );
        });
    }
}
