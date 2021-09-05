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
    public static function getContent(string $path)
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
                'route'      => 'wiki.index',
                'parameters' => ['page' => 'home'],
                'title'      => 'Home',
                'external'   => false
            ],
            [
                'route'      => 'wiki.index',
                'parameters' => ['page' => 'setup'],
                'title'      => 'Setup',
                'external'   => false
            ],
            [
                'route'      => 'wiki.index',
                'parameters' => ['page' => 'usage'],
                'title'      => 'Usage',
                'external'   => false
            ],
            [
                'route'      => 'wiki.index',
                'parameters' => ['page' => 'packages'],
                'title'      => 'Packages',
                'external'   => false
            ],
            [
                'route'      => 'wiki.index',
                'parameters' => ['page' => 'deployment'],
                'title'      => 'Deployment',
                'external'   => false
            ],
        ];

        return view('pages.wiki.index', compact('date', 'content', 'links'));
    }

    public function index(Request $request)
    {
        $page = $request->page ?? 'home';
        $path = resource_path("views/pages/wiki/content/$page.md");

        return self::getContent($path);
    }
}
