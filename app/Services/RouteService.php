<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as RoutingRoute;

class RouteService
{
    public static function getList(string $filter = null): array
    {
        $routes = Route::getRoutes();
        $routes = $routes->getRoutes();

        // $accepted_routes = [
        //     'api.v1.books.index',
        //     'api.v1.books.show',
        //     'api.v1.books.related',
        //     'api.v1.authors.index',
        //     'api.v1.authors.show',
        //     'api.v1.authors.show.books',
        //     'api.v1.series.index',
        //     'api.v1.series.show',
        //     'api.v1.series.show.books',
        // ];
        // $selected_routes = [];
        // foreach ($routeCollection as $key => $route) {
        //     if (in_array($route->getName(), $accepted_routes)) {
        //         array_push($selected_routes, $route);
        //     }
        // }

        // $routes = [];
        // $publicRoutes = [];
        // foreach ($selected_routes as $route) {
        //     if (preg_match('/api/', $route->uri) && ! preg_match('/l5-swagger/', $route->getName()) && ! preg_match('/tokens/', $route->uri())) {
        //         $fullRoute = config('app.url').'/'.$route->uri();
        //         $paramsList = [];
        //         if (preg_match('/[{]/i', $fullRoute)) {
        //             $params = explode('/', $route->uri());
        //             foreach ($params as $key => $param) {
        //                 if (preg_match('/[{]/i', $param)) {
        //                     $param = str_replace('{', '', $param);
        //                     $param = str_replace('}', '', $param);
        //                     $routeParam = null;
        //                     try {
        //                         $routeParam = route('api.v1.'.$param.'s.index');
        //                     } catch (\Throwable $th) {
        //                         //throw $th;
        //                     }
        //                     array_push($paramsList, [
        //                         'parameter' => $param,
        //                         'attribute' => 'slug',
        //                         'route'     => $routeParam,
        //                     ]);
        //                 }
        //             }
        //         }
        //         $params_example = [];
        //         foreach ($paramsList as $key => $param) {
        //             $model_name = 'App\Models\\'.ucfirst($param['parameter']);
        //             try {
        //                 if (is_string($model_name)) {
        //                     $entity = $model_name::first();
        //                     $params_example[$param['parameter']] = $entity->slug;
        //                 }
        //             } catch (\Throwable $th) {
        //                 //throw $th;
        //             }
        //         }
        //         $uri = $route->uri();
        //         foreach ($params_example as $key => $param) {
        //             $uri = str_replace('{'.$key.'}', $param, $uri);
        //         }
        //         $routes[$route->getName() ? $route->getName() : $route->uri()] = [
        //             'name'   => $route->getName(),
        //             'method' => $route->methods()[0],
        //             'uri'    => $route->uri(),
        //             // 'action' => str_replace('App\\Http\\Controllers\\Api\\', '', $route->getActionName()),
        //             // 'middleware' => $route->middleware(),
        //             'example'    => config('app.url')."/$uri",
        //             'parameters' => sizeof($paramsList) > 0 ? $paramsList : null,
        //         ];
        //     }
        // }

        // foreach ($routes as $key => $route) {
        //     array_push($publicRoutes, $route);
        // }

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
}
