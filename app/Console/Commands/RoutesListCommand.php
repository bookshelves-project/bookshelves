<?php

namespace App\Console\Commands;

use App\Services\FileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Route;

class RoutesListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all routes into JSON file.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Artisan::call('route:list', [
        //     '--compact' => true,
        // ], $this->getOutput());

        $routes = Route::getRoutes();
        $routes = $routes->getRoutes();

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

        $list = [];
        foreach ($routes as $route) {
            $uri = $route->uri();
            // foreach ($params_example as $key => $param) {
            //     $uri = str_replace('{'.$key.'}', $param, $uri);
            // }

            $list[$route->uri()] = [
                'name' => $route->getName(),
                'method' => $route->methods()[0],
                'uri' => $route->uri(),
                // 'action' => str_replace('App\\Http\\Controllers\\Api\\', '', $route->getActionName()),
                // 'middleware' => $route->middleware(),
                'example' => config('app.url')."/{$uri}",
                // 'parameters' => sizeof($paramsList) > 0 ? $paramsList : null,
            ];
        }
        ksort($list);
        FileService::saveAsJson($list, 'routes');

        return 0;
    }
}
