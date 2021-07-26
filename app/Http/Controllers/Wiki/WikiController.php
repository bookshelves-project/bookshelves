<?php

namespace App\Http\Controllers\Wiki;

use File;
use DateTime;
use DateTimeZone;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Providers\CommonMark;
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
    public function index(Request $request)
    {
        $path = resource_path('views/pages/wiki/content/index.md');
        $markdown = File::get($path);
        $lastModified = File::lastModified($path);
        $lastModified = Carbon::createFromTimestamp($lastModified)->toDateString();

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

        $agent = new Agent();
        $device = $agent->device();

        $content = $converter->convertToHtml($markdown);

        return view('pages.wiki.index', compact('lastModified', 'markdown', 'content', 'device'));
    }
}
