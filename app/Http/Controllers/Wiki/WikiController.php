<?php

namespace App\Http\Controllers\Wiki;

use File;
use Illuminate\Http\Request;
use App\Providers\CommonMark;
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
        $content = File::get($path);
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

        $content = $converter->convertToHtml($content);

        return view('pages.wiki.index', compact('content'));
    }
}
