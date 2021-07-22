<?php

namespace App\Http\Controllers\Wiki;

use File;
use Illuminate\Http\Request;
use App\Providers\CommonMark;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Spatie\LaravelMarkdown\MarkdownRenderer;

/**
 * @hideFromAPIDocumentation
 */
class WikiController extends Controller
{
    public function index(Request $request)
    {
        $composer = file_get_contents(base_path('composer.json'));
        $composer = json_decode($composer);

        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;
        $appVersion = $composer->version;

        $path = resource_path('views/pages/wiki/content/index.md');
        $content = File::get($path);

        return view('pages.wiki.index', compact('laravelVersion', 'phpVersion', 'appVersion', 'content'));
    }
}
