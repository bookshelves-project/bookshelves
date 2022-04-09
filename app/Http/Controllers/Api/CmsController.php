<?php

namespace App\Http\Controllers\Api;

use App\Enums\NavigationCategoryEnum;
use App\Http\Resources\Api\Cms\NavigationResource;
use App\Http\Resources\Cms\ApplicationResource;
use App\Http\Resources\Cms\HomePageResource;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Cms\Application;
use App\Models\Cms\HomePage\HomePage;
use App\Models\Cms\Navigation;
use App\Models\Language;
use App\Services\EnumService;
use Illuminate\Http\Request;

/**
 * @group CMS
 */
class CmsController extends ApiController
{
    /**
     * GET Application.
     *
     * Useful for CMS at front-end init with `enums`, `languages` and `application`.
     */
    public function application()
    {
        return response()->json([
            'data' => [
                'enums' => EnumService::list(),
                'languages' => LanguageResource::collection(Language::all()),
                'application' => ApplicationResource::make(
                    Application::first()
                ),
            ],
        ]);
    }

    /**
     * GET Home page.
     */
    public function home()
    {
        if (null !== HomePage::first()) {
            return HomePageResource::make(
                HomePage::first()
            );
        }

        return abort(404);
    }

    public function navigation(Request $request)
    {
        $lang = $request->lang ?? 'en';
        app()->setLocale($lang);

        $navigation = Navigation::all();
        $grouped = collect($navigation->toArray());

        $grouped = $grouped->groupBy('category');
        $grouped->all();

        $navigation = [];
        foreach (NavigationCategoryEnum::toValues() as $category) {
            $grouped = Navigation::whereCategory($category)->get();
            $navigation[$category] = NavigationResource::collection($grouped);
        }
        // dd($navigation);

        // return NavigationResource::collection($navigation);

        return response()->json([
            'data' => $navigation,
        ]);
    }
}
