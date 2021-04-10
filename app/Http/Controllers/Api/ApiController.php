<?php

namespace App\Http\Controllers\Api;

use File;
use Route;
use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Bookshelves API",
 *     description="Documentation about Bookshelves API"
 * ),
 * @OA\Tag(
 *     name="global",
 *     description="Global requests"
 * ),
 * @OA\Tag(
 *     name="books",
 *     description="Books requests"
 * ),
 * @OA\Tag(
 *     name="series",
 *     description="Series requests"
 * ),
 * @OA\Tag(
 *     name="authors",
 *     description="Authors requests"
 * ),
 * @OA\Tag(
 *     name="search",
 *     description="Search requests"
 * ),
 * @OA\Tag(
 *     name="download",
 *     description="Download requests"
 * ),
 * @OA\Get(
 *     path="/",
 *     tags={"global"},
 *     summary="Basic documentation",
 *     description="Documentation to use this API",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
class ApiController extends Controller
{
    public function index()
    {
        $routes = [];
        $routeCollection = Route::getRoutes();
        $routeCollection = $routeCollection->getRoutes();

        $publicRoutes = [];
        $sanctumRoutes = [];
        foreach ($routeCollection as $route) {
            if (preg_match('/api/', $route->uri) && ! preg_match('/l5-swagger/', $route->getName()) && ! preg_match('/tokens/', $route->uri())) {
                $fullRoute = config('app.url').'/'.$route->uri();
                $paramsList = [];
                if (preg_match('/[{]/i', $fullRoute)) {
                    $params = explode('/', $route->uri());
                    foreach ($params as $key => $param) {
                        if (preg_match('/[{]/i', $param)) {
                            array_push($paramsList, $param);
                        }
                    }
                }
                $routes[$route->getName() ? $route->getName() : $route->uri()] = [
                    'name'       => $route->getName(),
                    'method'     => $route->methods()[0],
                    'uri'        => $route->uri(),
                    'action'     => str_replace('App\\Http\\Controllers\\Api\\', '', $route->getActionName()),
                    'middleware' => $route->middleware(),
                    'link'       => $fullRoute,
                    'parameters' => sizeof($paramsList) > 0 ? $paramsList : null,
                ];
            }
        }

        foreach ($routes as $key => $route) {
            if (in_array('auth:sanctum', $route['middleware'])) {
                array_push($sanctumRoutes, $route);
            } else {
                array_push($publicRoutes, $route);
            }
        }

        $composerJson = File::get(base_path('composer.json'));
        $composerJson = json_decode($composerJson);

        return response()->json([
            'success'        => 'Bookshelves API is available',
            'api-version'    => $composerJson->version,
            'about'          => [
                'public'  => 'Route with public access',
                'sanctum' => 'Routes available if user is logged',
            ],
            'documentation'  => config('app.url').'/'.'api/documentation',
            'ereader'        => config('app.url').'/'.'api/ereader',
            'routes'         => [
                'public'   => $publicRoutes,
                'sanctum'  => $sanctumRoutes,
            ],
        ], 200);
    }
}
