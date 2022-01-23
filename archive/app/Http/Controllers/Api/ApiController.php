<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Services\RouteService;
use Illuminate\Support\Facades\Route;
use Spatie\Tags\Tag;

class ApiController extends Controller
{
    /**
     * @hideFromAPIDocumentation
     */
    public function __construct()
    {
        Route::bind('author_slug', function (string $author) {
            return Author::whereSlug($author)->firstOrFail();
        });

        Route::bind('book_slug', function (string $book) {
            return Book::whereSlug($book)->firstOrFail();
        });

        Route::bind('serie_slug', function (string $serie) {
            return Serie::whereSlug($serie)->firstOrFail();
        });

        Route::bind('tag_slug', function (string $tag) {
            return Tag::where('slug->en', $tag)->firstOrFail();
        });

        Route::bind('publisher_slug', function (string $publisher) {
            return Publisher::whereSlug($publisher)->firstOrFail();
        });

        Route::bind('language_slug', function (string $language) {
            return Language::whereSlug($language)->firstOrFail();
        });
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function apiHome()
    {
        return response()->json([
            'name' => config('app.name').' API',
            'versions' => [
                'v1' => route('api.v1.v1'),
            ],
        ]);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function apiV1()
    {
        $list = RouteService::getList('api/v1');

        return response()->json([
            'name' => config('app.name').' API',
            'version' => 'v1',
            'routes' => [
                'application' => $this->getRouteData(config('app.front_url'), 'Main application', false),
                'catalog' => $this->getRouteData('features.catalog.index', 'UI for eReader browser to get eBooks on it'),
                'opds' => $this->getRouteData('features.opds.index', 'OPDS API for application which use it'),
                'webreader' => $this->getRouteData('features.webreader.index', 'UI to read directly an eBook into browser'),
                'admin' => $this->getRouteData('admin', 'For admin to manage data.'),
                'documentation' => $this->getRouteData(config('app.documentation_url'), 'Documentation for developers', false),
                'api-doc' => $this->getRouteData(route('scribe'), 'API documentation to use data on others applications', false),
                'repository' => $this->getRouteData(config('app.repository_url'), 'Repository of this application', false),
            ],
            'api' => $list,
        ], 200);
    }

    /**
     * @hideFromAPIDocumentation
     *
     * @param mixed $isLaravelRoute
     */
    private function getRouteData(string $route, string $description, $isLaravelRoute = true)
    {
        return [
            'route' => $isLaravelRoute ? route($route) : $route,
            'description' => $description,
        ];
    }
}
