<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use League\CommonMark\Environment;
use Illuminate\Support\Facades\File;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\Block\Renderer\FencedCodeRenderer;
use League\CommonMark\Block\Renderer\IndentedCodeRenderer;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;

class CommonMarkProvider
{
    public static function convertToHtml($markdown)
    {
        $languages = ['html', 'php', 'js', 'yaml', 'bash', 'xml'];

        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($languages));
        $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($languages));
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new ExternalLinkExtension());
        $environment->addExtension(new FootnoteExtension());
        $environment->addExtension(new SmartPunctExtension());
        $environment->addExtension(new TaskListExtension());
        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new DisallowedRawHtmlExtension());

        $environment->mergeConfig([
            'heading_permalink' => [
                'html_class'     => 'heading-permalink',
                'id_prefix'      => 'user-content',
                'inner_contents' => '',
                'insert'         => 'before',
                'title'          => 'Permalink',
            ],
            'table_of_contents' => [
                'html_class'        => 'table-of-contents',
                'position'          => 'top',
                'style'             => 'bullet',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'normalize'         => 'relative',
            ],
            'external_link' => [
                'internal_hosts'     => config('app.url'), // TODO: Don't forget to set this!
                'open_in_new_window' => true,
                'html_class'         => 'external-link',
                'nofollow'           => '',
                'noopener'           => 'external',
                'noreferrer'         => 'external',
            ],
            'footnote' => [
                'backref_class'      => 'footnote-backref',
                'container_add_hr'   => true,
                'container_class'    => 'footnotes',
                'ref_class'          => 'footnote-ref',
                'ref_id_prefix'      => 'fnref:',
                'footnote_class'     => 'footnote',
                'footnote_id_prefix' => 'fn:',
            ],
            'smartpunct' => [
                'double_quote_opener' => '“',
                'double_quote_closer' => '”',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],
        ]);

        $commonMarkConverter = new CommonMarkConverter([], $environment);

        return $commonMarkConverter->convertToHtml($markdown);
    }

    public static function generate(string $path, bool $absolute = false)
    {
        if (! $absolute) {
            $path = resource_path("views/pages/$path");
        }
        $markdown = File::get($path);
        $date = File::lastModified($path);
        $date = Carbon::createFromTimestamp($date)->toDateString();

        $environment = Environment::createCommonMarkEnvironment();
        $options = [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
            'external_link'      => [
                'internal_hosts'     => config('app.url'),
                'open_in_new_window' => true,
                'html_class'         => 'external-link',
                'nofollow'           => '',
                'noopener'           => 'external',
                'noreferrer'         => 'external',
            ],
        ];
        $langs = ['html', 'php', 'js', 'yaml', 'nginx', 'bash'];
        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($langs));
        $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($langs));
        $environment->addExtension(new ExternalLinkExtension());
        if (config('app.env') !== 'local') {
            $environment->addExtension(new HighlightCodeExtension('github-dark'));
        }

        $converter = new CommonMarkConverter($options, $environment);
        $content = $converter->convertToHtml($markdown);

        return json_decode(json_encode([
            'content' => $content,
            'date'    => $date
        ]));
    }
}
