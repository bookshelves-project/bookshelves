<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\CmsApplicationResource;
use App\Http\Resources\LanguageResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Cms\CmsApplication;
use App\Models\Language;
use App\Models\Serie;
use App\Services\EnumService;
use File;
use Illuminate\Support\Facades\Route;

/**
 * @hideFromAPIDocumentation
 */
class ApiController extends Controller
{
    public function __construct()
    {
        Route::bind('author', function (string $author) {
            return Author::whereSlug($author)->firstOrFail();
        });

        Route::bind('book', function (string $book) {
            return Book::whereSlug($book)->firstOrFail();
        });

        Route::bind('serie', function (string $serie) {
            return Serie::whereSlug($serie)->firstOrFail();
        });

        // Route::bind('post', function ($slug) {
        //     return Post::whereSlug($slug)->firstOrFail();
        // });

        // Route::bind('tag', function ($slug) {
        //     return Tag::whereSlug($slug)->firstOrFail();
        // });

        // Route::bind('offer', function ($slug) {
        //     return Offer::whereSlug($slug)->firstOrFail();
        // });

        // Route::bind('service', function ($slug) {
        //     return Service::whereSlug($slug)->firstOrFail();
        // });

        // Route::bind('sector', function ($slug) {
        //     return Sector::whereSlug($slug)->firstOrFail();
        // });

        // Route::bind('indice', function ($slug) {
        //     return Indice::whereSlug($slug)->firstOrFail();
        // });

        // Route::bind('jobOffer', function ($reference) {
        //     return JobOffer::whereReference($reference)->firstOrFail();
        // });

        // Route::bind('page', function ($slug) {
        //     return Page::whereSlug($slug)->firstOrFail();
        // });
    }

//     public function index()
//     {
//         $composerJson = File::get(base_path('composer.json'));
//         $composerJson = json_decode($composerJson);

//         return response()->json([
//             'name' => config('app.name').' API',
//             'version' => $composerJson->version,
//             'routes' => [
//                 'catalog' => $this->getRouteData('features.catalog.index', 'UI for eReader browser to get eBooks on it.'),
//                 'opds' => $this->getRouteData('features.opds.index', 'OPDS API for application which use it.'),
//                 'webreader' => $this->getRouteData('features.webreader.index', 'UI to read directly an eBook into browser.'),
//                 // 'wiki' => $this->getRouteData('features.documentation.page', 'Wiki for setup and usage, useful for developers.'),
//                 // 'roadmap' => $this->getRouteData('features.roadmap.index', 'Features planned and ideas.'),
//                 'admin' => $this->getRouteData('admin', 'For admin to manage data.'),
//                 'api-doc' => $this->getRouteData(config('app.url').'/docs', 'API documentation to use data on others applications', false),
//                 'repository' => $this->getRouteData(config('app.repository_url'), 'Repository of this application', false),
//             ],
//         ], 200);
//     }

//     public function getRouteData(string $route, string $description, $isLaravelRoute = true)
//     {
//         return [
//             'route' => $isLaravelRoute ? route($route) : $route,
//             'description' => $description,
//         ];
//     }

//     public function init()
//     {
//         return response()->json([
//             'data' => [
//                 'enums' => EnumService::list(),
//                 'languages' => LanguageResource::collection(Language::all()),
//                 'application' => CmsApplicationResource::make(
//                     CmsApplication::first()
//                 ),
//             ],
//         ]);
//     }
}
