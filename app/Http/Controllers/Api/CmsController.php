<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\CmsApplicationResource;
use App\Http\Resources\Cms\CmsHomePageResource;
use App\Models\Cms\CmsApplication;
use App\Models\Cms\CmsHomePage;

class CmsController extends Controller
{
    public function application()
    {
        return CmsApplicationResource::make(
            CmsApplication::first()
        );
    }

    public function home()
    {
        return CmsHomePageResource::make(
            CmsHomePage::first()
        );
    }
}
