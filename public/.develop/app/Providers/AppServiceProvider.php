<?php

namespace App\Providers;

use App\Support\LaravelViteManifest;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Vite;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton('laravel-vite-manifest', function () {
            return new LaravelViteManifest();
        });

        Builder::macro('whereLike', function (array $attributes, string $searchTerm) {
            // @phpstan-ignore-next-line
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Translatable::fallback(
            fallbackAny: true,
        );

        // Blade::directive('vite', function ($expression) {
        //     return '{!! App\Facades\ViteManifest::embed('.$expression.') !!}';
        // });

        // View::addNamespace('front', resource_path('front'));
        // View::addNamespace('admin', resource_path('admin'));
        // View::addNamespace('webreader', resource_path('webreader'));

        Filament::serving(function () {
            // Filament::registerNavigationGroups([
            //     'Blog',
            //     'Créations',
            //     'Contenus',
            //     'Avancé',
            // ]);
            Filament::registerTheme(
                app(Vite::class)('resources/css/filament.css'),
            );
        });
    }
}
