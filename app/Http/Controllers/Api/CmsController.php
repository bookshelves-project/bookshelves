<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Cms\CmsApplicationResource;
use App\Http\Resources\Cms\CmsHomePageResource;
use App\Http\Resources\Language\LanguageResource;
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
                'application' => CmsApplicationResource::make(
                    CmsApplication::first()
                ),
            ],
        ]);
    }

    /**
     * GET Home page.
     */
    public function home()
    {
        if (null !== CmsHomePage::first()) {
            return CmsHomePageResource::make(
                CmsHomePage::first()
            );
        }

        return abort(404);
    }
}
