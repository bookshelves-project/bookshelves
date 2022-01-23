<?php

namespace App\Providers;

use App\Support\LaravelViteManifest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
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
        Blade::directive('vite', function ($expression) {
            return '{!! App\Facades\ViteManifest::embed('.$expression.') !!}';
        });

        View::addNamespace('front', resource_path('front'));
        View::addNamespace('admin', resource_path('admin'));

        /*
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        // Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
        //     $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

        //     // return new LengthAwarePaginator(
        //     //     $this->forPage($page, $perPage),
        //     //     $total ?: $this->count(),
        //     //     $perPage,
        //     //     $page,
        //     //     [
        //     //         'path' => LengthAwarePaginator::resolveCurrentPath(),
        //     //         'pageName' => $pageName,
        //     //     ]
        //     // );
        // });
    }
}
