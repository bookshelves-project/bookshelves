<?php

namespace App\Providers;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;
use Kiwilan\Steward\Components\Field\FieldRichEditor;
use Kiwilan\Steward\Http\Livewire\Editor;
use Livewire;
use Opcodes\LogViewer\Facades\LogViewer;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::addNamespace('admin', resource_path('admin'));
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

        Livewire::component('editor', FieldRichEditor::class);

        LogViewer::auth(function ($request) {
            /** @var User */
            $user = $request->user();

            return $user->is_admin || $user->is_super_admin;
        });
    }
}
