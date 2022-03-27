<?php

namespace App\Services;

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

class RouteService
{
    public static function getList(): array
    {
        $routes = Route::getRoutes()->getRoutes();

        return self::filter($routes);
    }

    public static function getListFiltered(string $filter = null): array
    {
        $routes = Route::getRoutes()->getRoutes();

        $list = [];
        foreach ($routes as $route) {
            $uri = $route->uri();
            // foreach ($params_example as $key => $param) {
            //     $uri = str_replace('{'.$key.'}', $param, $uri);
            // }
            $filtered = null !== $filter ? str_contains($uri, $filter) : true;

            if ($filtered) {
                $list[$route->getName()] = self::getRoute($route, $uri);
            }
        }
        ksort($list);

        return $list;
    }

    private static function getRoute(RoutingRoute $route, string $uri)
    {
        return [
            'name' => $route->getName(),
            'method' => $route->methods()[0],
            'uri' => $route->uri(),
            // 'action' => str_replace('App\\Http\\Controllers\\Api\\', '', $route->getActionName()),
            // 'middleware' => $route->middleware(),
            'example' => config('app.url')."/{$uri}",
            // 'parameters' => sizeof($paramsList) > 0 ? $paramsList : null,
        ];
    }

    private static function filter(array $routes)
    {
        $accepted_routes = [
            'api.books.index',
            'api.books.show',
            'api.books.related',
            'api.authors.index',
            'api.authors.show',
            'api.authors.show.books',
            'api.series.index',
            'api.series.show',
            'api.series.show.books',
        ];
        $selected_routes = [];
        foreach ($routes as $key => $route) {
            if (in_array($route->getName(), $accepted_routes)) {
                array_push($selected_routes, $route);
            }
        }

        $routes = [];
        $publicRoutes = [];
        foreach ($selected_routes as $route) {
            if (preg_match('/api/', $route->uri)) {
                $fullRoute = config('app.url').'/'.$route->uri();
                $paramsList = [];
                if (preg_match('/[{]/i', $fullRoute)) {
                    $params = explode('/', $route->uri());
                    foreach ($params as $key => $param) {
                        if (preg_match('/[{]/i', $param)) {
                            $param = str_replace('{', '', $param);
                            $param = str_replace('}', '', $param);
                            $routeParam = null;
                            try {
                                $routeParam = route('api.'.$param.'s.index');
                            } catch (\Throwable $th) {
                                // throw $th;
                            }
                            array_push($paramsList, [
                                'parameter' => $param,
                                'attribute' => 'slug',
                                'route' => $routeParam,
                            ]);
                        }
                    }
                }
                $params_example = [];
                foreach ($paramsList as $key => $param) {
                    $model_name = match ($param['parameter']) {
                        'author_slug' => 'Author',
                        'book_slug' => 'Book',
                        'serie_slug' => 'Serie',
                        default => 'Book',
                    };
                    $model_name = "App\\Models\\{$model_name}";
                    try {
                        if (is_string($model_name)) {
                            $entity = $model_name::inRandomOrder()
                                ->first()
                            ;
                            $params_example[$param['parameter']] = $entity->slug;
                        }
                    } catch (\Throwable $th) {
                        // throw $th;
                    }
                }
                $uri = $route->uri();
                foreach ($params_example as $key => $param) {
                    $uri = str_replace('{'.$key.'}', $param, $uri);
                }
                $routes[$route->getName() ? $route->getName() : $route->uri()] = [
                    'name' => $route->getName(),
                    'method' => $route->methods()[0],
                    'uri' => $route->uri(),
                    // 'action' => str_replace('App\\Http\\Controllers\\Api\\', '', $route->getActionName()),
                    // 'middleware' => $route->middleware(),
                    'example' => config('app.url')."/{$uri}",
                    'parameters' => sizeof($paramsList) > 0 ? $paramsList : null,
                ];
            }
        }

        foreach ($routes as $key => $route) {
            array_push($publicRoutes, $route);
        }

        return $publicRoutes;
    }
}
