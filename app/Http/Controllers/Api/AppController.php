<?php

namespace App\Http\Controllers\Api;

use App\Enums\NavigationCategoryEnum;
use App\Http\Resources\Api\Cms\NavigationResource;
use App\Http\Resources\Cms\ApplicationResource;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Cms\Application;
use App\Models\Cms\Navigation;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Services\EnumService;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\Tags\Tag;

#[Prefix('app')]
class AppController extends Controller
{
    /**
     * GET Application.
     *
     * Useful for CMS at front-end init with `enums`, `languages` and `application`.
     */
    #[Get('/', name: 'api.app.index')]
    public function application()
    {
        return response()->json([
            'data' => [
                'enums' => EnumService::list(),
                'languages' => LanguageResource::collection(Language::all()),
                // 'application' => ApplicationResource::make(
                //     Application::first()
                // ),
            ],
        ]);
    }

    // public function navigation(Request $request)
    // {
    //     $lang = $request->lang ?? 'en';
    //     app()->setLocale($lang);

    //     $navigation = Navigation::all();
    //     $grouped = collect($navigation->toArray());

    //     $grouped = $grouped->groupBy('category');
    //     $grouped->all();

    //     $navigation = [];

    //     foreach (NavigationCategoryEnum::toValues() as $category) {
    //         $grouped = Navigation::whereCategory($category)->get();
    //         $navigation[$category] = NavigationResource::collection($grouped);
    //     }
    //     // dd($navigation);

    //     // return NavigationResource::collection($navigation);

    //     return response()->json([
    //         'data' => $navigation,
    //     ]);
    // }

    #[Get('/stats', name: 'api.app.stats')]
    public function stats()
    {
        $stats = [
            'books' => Book::count(),
            'authors' => Author::count(),
            'series' => Serie::count(),
            'tags' => Tag::count(),
            'publishers' => Publisher::count(),
            'languages' => Language::count(),
        ];

        return response()->json([
            'data' => $stats,
        ]);
    }

    /**
     * GET Count.
     *
     * Get count of entities for a selected collection. Available for Book, Serie and Author.
     *
     * @queryParam entities required `key` of enums.models' list. Example: author,book,serie
     * @queryParam languages required `slug` of languages' list `meta.slug`. Example: fr,en
     */
    #[Get('/count', name: 'api.app.count')]
    public function count(Request $request)
    {
        // http://localhost:8000/api/v1/count?entities=book,author,serie&languages=fr,en

        $entities = $request->get('entities');
        $languages = $request->get('languages');

        $models_count = [];
        $count_languages = [];

        if ($entities) {
            $models_raw = explode(',', $entities);
            $models = [];

            foreach ($models_raw as $key => $value) {
                $models[$value] = 'App\Models\\'.ucfirst($value);
            }

            foreach ($models as $key => $model_name) {
                $count = $model_name::count();
                $models_count[$key] = $count;
            }
        }

        if ($languages) {
            $languages_raw = explode(',', $languages);

            foreach ($languages_raw as $key => $value) {
                $count = Book::whereLanguageSlug($value)->count();
                $count_languages[$value] = $count;
            }
        }

        return response()->json([
            'data' => [
                'entities' => $models_count,
                'languages' => $count_languages,
            ],
        ]);
    }

    /**
     * GET Enums.
     */
    public function enums()
    {
        return response()->json([
            'data' => EnumService::list(),
        ]);
    }
}
