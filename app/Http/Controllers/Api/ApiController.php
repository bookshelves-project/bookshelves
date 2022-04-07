<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagLightResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Page;
use App\Models\Post;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\TagExtend;
use App\Models\User;
use App\Services\RouteService;
use App\Utils\BookshelvesTools;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Spatie\Tags\Tag;

class ApiController extends Controller
{
    /**
     * @hideFromAPIDocumentation
     */
    public function __construct()
    {
        Route::bind(
            'author_slug',
            fn ($slug) => Author::whereSlug($slug)
                ->withCount('books', 'series')
                ->firstOrFail()
        );

        Route::bind('book_slug', fn ($slug) => Book::whereSlug($slug)->withCount('reviews')->firstOrFail());

        Route::bind(
            'serie_slug',
            fn ($slug) => Serie::whereSlug($slug)
                ->withCount('books')
                ->firstOrFail()
        );

        Route::bind('entity_slug', function ($slug) {
            return Book::whereSlug($slug)->firstOrFail();
        });

        Route::bind('tag_slug', fn ($slug) => Tag::where('slug->en', $slug)->firstOrFail());

        Route::bind(
            'publisher_slug',
            fn ($slug) => Publisher::whereSlug($slug)
                ->withCount('books')
                ->firstOrFail()
        );

        Route::bind('language_slug', fn ($slug) => Language::whereSlug($slug)->firstOrFail());

        Route::bind('post_slug', fn ($slug) => Post::whereSlug($slug)->firstOrFail());

        Route::bind('page_slug', fn ($slug) => Page::whereSlug($slug)->firstOrFail());

        Route::bind('user_slug', fn ($slug) => User::whereSlug($slug)->firstOrFail());
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function home()
    {
        $list = RouteService::getList();

        return response()->json([
            'name' => config('app.name').' API',
            'version' => 'v1',
            'routes' => [
                'application' => $this->getRouteData(config('app.front_url'), 'Main application', false),
                'catalog' => $this->getRouteData('front.catalog', 'UI for eReader browser to get books on it'),
                'opds' => $this->getRouteData('front.opds', 'OPDS API for application which use it'),
                'webreader' => $this->getRouteData('front.webreader', 'UI to read directly an eBook into browser'),
                'admin' => $this->getRouteData('admin.dashboard', 'For admin to manage data.'),
                'documentation' => $this->getRouteData(config('app.documentation_url'), 'Documentation for developers', false),
                'api-doc' => $this->getRouteData(route('scribe'), 'API documentation to use data on others applications', false),
                'repository' => $this->getRouteData(config('app.repository_url'), 'Repository of this application', false),
            ],
            'api' => $list,
        ], 200);
    }

    protected function getLang(Request $request)
    {
        $lang = $request->lang ? $request->lang : config('app.locale');
        App::setLocale($lang);
    }

    protected function getPaginationSize(Request $request, int $default = 32): int
    {
        return $request->size ? $request->size : $default;
    }

    protected function getFull(Request $request): bool
    {
        return $request->parseBoolean('full');
    }

    protected function getEntity(string $entity): string
    {
        $model_name = ucfirst($entity);

        return "App\\Models\\{$model_name}";
    }

    /**
     * @return false|JsonResponse
     */
    protected function chunkByAlpha(Request $request, string $model, string $resource)
    {
        $alpha = $request->parseBoolean('alpha');

        if ($alpha) {
            $filter = $request->get('filter');
            $list = [];

            if ($filter && array_key_exists('type', $filter)) {
                $type = $filter['type'];
                $models = $model::whereTypeIs($type)->get();
            } else {
                $models = $model::all();
            }
            $models_sorted = BookshelvesTools::chunkByAlpha($models, 'first_char');

            foreach ($models_sorted as $char => $models_char) {
                $list[$char] = $resource::collection($models_char);
            }

            return response()->json([
                'data' => $list,
            ]);
        }

        return false;
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
