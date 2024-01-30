<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Kiwilan\Steward\Utils\Markdown;
use Kiwilan\Steward\Utils\Markdown\MarkdownOptions;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('pages')]
class PageController extends Controller
{
    #[Get('/help', name: 'pages.help')]
    public function help()
    {
        $path = resource_path('markdown/help.md');
        $md = Markdown::make($path, new MarkdownOptions(
            config: [
                'html_input' => 'allow',
            ],
        ));

        return inertia('Page', [
            'icon' => 'info',
            'contents' => $md->getHtml(),
            'headers' => $md->getHeaders(),
            'frontmatter' => $md->getFrontmatter()->toArray(),
        ]);
    }
}
