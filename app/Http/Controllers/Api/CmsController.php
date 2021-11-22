<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\ApplicationResource;
use App\Http\Resources\Cms\HomePageResource;
use App\Models\Cms\Application;
use App\Models\Cms\HomePage;

class CmsController extends Controller
{
    public function application()
    {
        return ApplicationResource::make(
            Application::first()
        );
    }

    public function home()
    {
        return HomePageResource::make(
            HomePage::first()
        );
    }
}
