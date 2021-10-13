<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use File;
use Route;

/**
 * @hideFromAPIDocumentation
 */
class ApiController extends Controller
{
    public function index()
    {
        // $routeCollection = Route::getRoutes();
        // $routeCollection = $routeCollection->getRoutes();

        // $accepted_routes = [
        //     'api.books.index',
        //     'api.books.show',
        //     'api.books.related',
        //     'api.authors.index',
        //     'api.authors.show',
        //     'api.authors.show.books',
        //     'api.series.index',
        //     'api.series.show',
        //     'api.series.show.books',
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
        //                         $routeParam = route('api.'.$param.'s.index');
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

        $composerJson = File::get(base_path('composer.json'));
        $composerJson = json_decode($composerJson);

        return response()->json([
            'name' => config('app.name').' API',
            'version' => $composerJson->version,
            'routes' => [
                'catalog' => $this->getRouteData('features.catalog.index', 'UI for eReader browser to get eBooks on it.'),
                'opds' => $this->getRouteData('features.opds.index', 'OPDS API for application which use it.'),
                'webreader' => $this->getRouteData('features.webreader.index', 'UI to read directly an eBook into browser.'),
                'wiki' => $this->getRouteData('features.wiki.index', 'Wiki for setup and usage, useful for developers.'),
                'roadmap' => $this->getRouteData('features.roadmap.index', 'Features planned and ideas.'),
                'admin' => $this->getRouteData('admin', 'For admin to manage data.'),
                'api-doc' => $this->getRouteData(config('app.url').'/docs', 'API documentation to use data on others applications', false),
                'repository' => $this->getRouteData(config('app.repository'), 'Repository of this application', false),
            ],
        ], 200);
    }

    public function getRouteData(string $route, string $description, $isLaravelRoute = true)
    {
        return [
            'route' => $isLaravelRoute ? route($route) : $route,
            'description' => $description,
        ];
    }
}
