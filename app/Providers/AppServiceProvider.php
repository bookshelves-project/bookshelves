<?php

namespace App\Providers;

use App\Support\LaravelViteManifest;
use Illuminate\Database\Eloquent\Builder;
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
                        // @phpstan-ignore-next-line
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

        Blade::directive('vite', function ($expression) {
            return '{!! App\Facades\ViteManifest::embed('.$expression.') !!}';
        });

        View::addNamespace('front', resource_path('front'));
        View::addNamespace('admin', resource_path('admin'));
        View::addNamespace('webreader', resource_path('webreader'));

        Request::macro('parseArray', function ($key): array {
            if ($value = request()->get($key)) {
                return is_array($value) ? $value : explode(',', $value);
            }

            return [];
        });

        Request::macro('parseBoolean', function (string $key, bool $default = false): bool {
            if ($value = request()->get($key)) {
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }

            return $default;
        });
    }
}
