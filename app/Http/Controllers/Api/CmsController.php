<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Cms\HomePageResource;
use App\Models\Cms\HomePage\HomePage;

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
