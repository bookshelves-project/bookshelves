<?php

namespace App\Http\Controllers\Wiki;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use League\CommonMark\Environment;
use App\Http\Controllers\Controller;
use League\CommonMark\CommonMarkConverter;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use League\CommonMark\Block\Renderer\FencedCodeRenderer;
use League\CommonMark\Block\Renderer\IndentedCodeRenderer;

/**
 * @hideFromAPIDocumentation
 */
class WikiController extends Controller
{
    public static function getContent(string $path)
    {
        $markdown = File::get($path);
        $date = File::lastModified($path);
        $date = Carbon::createFromTimestamp($date)->toDateString();

        // $content = app(MarkdownRenderer::class)
        //                 ->highlightTheme('github-dark')
        //                 ->toHtml($content);
        
        $environment = Environment::createCommonMarkEnvironment();
        $options = [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ];
        $langs = ['html', 'php', 'js', 'yaml', 'nginx', 'bash'];
        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($langs));
        $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($langs));

        $converter = new CommonMarkConverter($options, $environment);
        $content = $converter->convertToHtml($markdown);

        $links = [
            'home',
            'setup',
            'usage',
            'packages',
            'deployment'
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
