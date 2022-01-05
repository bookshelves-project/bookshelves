<?php

namespace App\Http\Controllers\Features\Development;

use App\Http\Controllers\Controller;
use App\Services\CommonMarkService;
use App\Services\FileService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

/**
 * @hideFromAPIDocumentation
 */
class DevelopmentController extends Controller
{
    public const LINKS = [
        [
            'slug' => 'home',
            'title' => 'Home',
        ],
        [
            'slug' => 'setup',
            'title' => 'Setup',
        ],
        [
            'slug' => 'dotenv',
            'title' => '.env',
        ],
        [
            'slug' => 'roadmap',
            'title' => 'Roadmap',
        ],
        [
            'slug' => 'usage',
            'title' => 'Usage',
        ],
        [
            'slug' => 'search',
            'title' => 'Search',
        ],
        [
            'slug' => 'packages',
            'title' => 'Packages',
        ],
        [
            'slug' => 'deployment',
            'title' => 'Deployment',
        ],
    ];

    public function page(Request $request)
    {
        if (! $request->page) {
            return redirect(route('features.development.page', ['page' => 'home']));
        }
        $page = $request->page ?? 'home';
        $path = "development/{$page}.md";

        SEOTools::setTitle(self::getTitle($page));

        return self::getContent($path, $page);
    }

    public static function getContent(string $path, string $page)
    {
        $markdown = CommonMarkService::generate($path);
        $content = $markdown->content;
        $date = $markdown->date;

        $links = [];
        foreach (self::LINKS as $link) {
            array_push($links, [
                'route' => 'features.development.page',
                'parameters' => ['page' => $link['slug']],
                'title' => $link['title'],
                'external' => false,
            ]);
        }
        $links = FileService::arrayToObject($links);
        $title = self::getTitle($page);

        return view('features::pages.development.page', compact('date', 'content', 'links', 'page', 'title'));
    }

    private static function getTitle(string $page): string
    {
        $links = self::LINKS;
        $title_id = array_search($page, array_column($links, 'slug'));
        $meta = $links[$title_id];

        return $meta['title'];
    }
}
