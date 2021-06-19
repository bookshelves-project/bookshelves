<?php

namespace App\Http\Controllers\Api\Wiki;

use File;
use Illuminate\Http\Request;
use App\Providers\CommonMark;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;

class WikiController extends Controller
{
    public function index(Request $request)
    {
        $composer = file_get_contents(base_path('composer.json'));
        $composer = json_decode($composer);

        // $php = $composer->{'require'}->php;
        // $laravel = $composer->{'require'}->{'laravel/framework'};

        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;

        $path = resource_path('views/pages/api/wiki/content/index.md');
        $content = File::get($path);

        $html = CommonMark::convertToHtml($content);

        return view('pages.api.wiki.index', compact('laravelVersion', 'phpVersion', 'html'));
    }
}
