<?php

namespace App\Http\Controllers\Wiki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\CommonMarkProvider;

/**
 * @hideFromAPIDocumentation
 */
class WikiController extends Controller
{
    public static function getContent(string $path, string $page)
    {
        $markdown = CommonMarkProvider::generate($path);
        $content = $markdown->content;
        $date = $markdown->date;

        // $links = [
        //     'home',
        //     'setup',
        //     'usage',
        //     'packages',
        //     'deployment'
        // ];
        $links = [
            [
                'route'      => 'features.wiki.index',
                'parameters' => ['page' => 'home'],
                'title'      => 'Home',
                'external'   => false
            ],
            [
                'route'      => 'features.wiki.index',
                'parameters' => ['page' => 'setup'],
                'title'      => 'Setup',
                'external'   => false
            ],
            [
                'route'      => 'features.wiki.index',
                'parameters' => ['page' => 'dotenv'],
                'title'      => '.env',
                'external'   => false
            ],
            [
                'route'      => 'features.wiki.index',
                'parameters' => ['page' => 'usage'],
                'title'      => 'Usage',
                'external'   => false
            ],
            [
                'route'      => 'features.wiki.index',
                'parameters' => ['page' => 'packages'],
                'title'      => 'Packages',
                'external'   => false
            ],
            [
                'route'      => 'features.wiki.index',
                'parameters' => ['page' => 'deployment'],
                'title'      => 'Deployment',
                'external'   => false
            ],
        ];

        return view('pages.features.wiki.index', compact('date', 'content', 'links', 'page'));
    }

    public function index(Request $request)
    {
        if (! $request->page) {
            return redirect(route('features.wiki.index', ['page' => 'home']));
        }
        $page = $request->page ?? 'home';
        $path = "wiki/content/$page.md";

        return self::getContent($path, $page);
    }
}
