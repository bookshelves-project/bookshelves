<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Cms\CmsApplicationResource;
use App\Http\Resources\Cms\CmsHomePageResource;
use App\Http\Resources\LanguageResource;
use App\Models\Cms\CmsApplication;
use App\Models\Cms\CmsHomePage;
use App\Models\Language;
use App\Services\EnumService;

/**
 * @group CMS
 */
class CmsController extends ApiController
{
    /**
     * GET Application & Home page.
     */
    public function index()
    {
        return response()->json([
            'data' => [
                'application' => route('api.cms.application'),
                'home_page' => route('api.cms.home-page'),
            ],
        ]);
    }

    /**
     * GET Application.
     */
    public function application()
    {
        return CmsApplicationResource::make(
            CmsApplication::first()
        );
    }

    /**
     * GET Home page.
     */
    public function home()
    {
        return CmsHomePageResource::make(
            CmsHomePage::first()
        );
    }

    /**
     * GET Initialization.
     *
     * Useful for CMS at front-end init with `enums`, `languages` and `application`.
     */
    public function initialization()
    {
        return response()->json([
            'data' => [
                'enums' => EnumService::list(),
                'languages' => LanguageResource::collection(Language::all()),
                'application' => CmsApplicationResource::make(
                    CmsApplication::first()
                ),
            ],
        ]);
    }
}
