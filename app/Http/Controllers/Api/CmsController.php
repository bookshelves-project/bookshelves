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
}
