<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;

class CommonMarkProvider
{
    public function __construct(
        public string $content,
        public string $date,
    ) {
    }

    // public static function convertToHtml($markdown)
    // {
    //     $languages = ['html', 'php', 'js', 'yaml', 'bash', 'xml'];

    //     $environment = Environment::createCommonMarkEnvironment();
    //     $environment->addExtension(new HeadingPermalinkExtension());
    //     $environment->addExtension(new TableOfContentsExtension());
    //     $environment->addExtension(new GithubFlavoredMarkdownExtension());
    //     $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($languages));
    //     $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($languages));
    //     $environment->addExtension(new AttributesExtension());
    //     $environment->addExtension(new ExternalLinkExtension());
    //     $environment->addExtension(new FootnoteExtension());
    //     $environment->addExtension(new SmartPunctExtension());
    //     $environment->addExtension(new TaskListExtension());
    //     $environment->addExtension(new AutolinkExtension());
    //     $environment->addExtension(new DisallowedRawHtmlExtension());

    //     $environment->mergeConfig([
    //         'heading_permalink' => [
    //             'html_class'     => 'heading-permalink',
    //             'id_prefix'      => 'user-content',
    //             'inner_contents' => '',
    //             'insert'         => 'before',
    //             'title'          => 'Permalink',
    //         ],
    //         'table_of_contents' => [
    //             'html_class'        => 'table-of-contents',
    //             'position'          => 'top',
    //             'style'             => 'bullet',
    //             'min_heading_level' => 1,
    //             'max_heading_level' => 6,
    //             'normalize'         => 'relative',
    //         ],
    //         'external_link' => [
    //             'internal_hosts'     => config('app.url'), // TODO: Don't forget to set this!
    //             'open_in_new_window' => true,
    //             'html_class'         => 'external-link',
    //             'nofollow'           => '',
    //             'noopener'           => 'external',
    //             'noreferrer'         => 'external',
    //         ],
    //         'footnote' => [
    //             'backref_class'      => 'footnote-backref',
    //             'container_add_hr'   => true,
    //             'container_class'    => 'footnotes',
    //             'ref_class'          => 'footnote-ref',
    //             'ref_id_prefix'      => 'fnref:',
    //             'footnote_class'     => 'footnote',
    //             'footnote_id_prefix' => 'fn:',
    //         ],
    //         'smartpunct' => [
    //             'double_quote_opener' => '“',
    //             'double_quote_closer' => '”',
    //             'single_quote_opener' => '‘',
    //             'single_quote_closer' => '’',
    //         ],
    //     ]);

    //     $commonMarkConverter = new CommonMarkConverter([], $environment);

    //     return $commonMarkConverter->convertToHtml($markdown);
    // }

    public static function generate(string $path, bool $absolute = false)
    {
        if (! $absolute) {
            $path = resource_path("views/pages/features/$path");
        }
        $markdown = File::get($path);
        $date = File::lastModified($path);
        $date = Carbon::createFromTimestamp($date)->toDateString();

        // $environment = Environment::createCommonMarkEnvironment();

        // $langs = ['html', 'php', 'js', 'yaml', 'nginx', 'bash'];

        // $environment->addExtension(new CommonMarkCoreExtension());
        // $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($langs));
        // $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($langs));
        // $environment->addExtension(new ExternalLinkExtension());
        
        // $environment->addExtension(new GithubFlavoredMarkdownExtension());

        // $converter = new CommonMarkConverter($options, $environment);
        // $converter = new MarkdownConverter($environment);

        // Define your configuration, if needed
        $config = [
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
            'default_attributes' => [
                Heading::class => [
                    'class' => static function (Heading $node) {
                        if ($node->getLevel() === 1) {
                            return 'title-main';
                        }
                    },
                ],
                Table::class => [
                    'class' => 'table',
                ],
                Paragraph::class => [
                    'class' => ['text-center', 'font-comic-sans'],
                ],
                Link::class => [
                    'class'  => 'btn btn-link',
                    'target' => '_blank',
                ],
            ],
            'footnote' => [
                'backref_class'      => 'footnote-backref',
                'backref_symbol'     => '↩',
                'container_add_hr'   => true,
                'container_class'    => 'footnotes',
                'ref_class'          => 'footnote-ref',
                'ref_id_prefix'      => 'fnref:',
                'footnote_class'     => 'footnote',
                'footnote_id_prefix' => 'fn:',
            ],
            'heading_permalink' => [
                'html_class'        => 'heading-permalink',
                'id_prefix'         => 'content',
                'fragment_prefix'   => 'content',
                'insert'            => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title'             => 'Permalink',
                'symbol'            => '',
            ],
            'mentions' => [
                // GitHub handler mention configuration.
                // Sample Input:  `@colinodell`
                // Sample Output: `<a href="https://www.github.com/colinodell">@colinodell</a>`
                'github_handle' => [
                    'prefix'    => '@',
                    'pattern'   => '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)',
                    'generator' => 'https://github.com/%s',
                ],
                // GitHub issue mention configuration.
                // Sample Input:  `#473`
                // Sample Output: `<a href="https://github.com/thephpleague/commonmark/issues/473">#473</a>`
                'github_issue' => [
                    'prefix'    => '#',
                    'pattern'   => '\d+',
                    'generator' => "https://github.com/thephpleague/commonmark/issues/%d",
                ],
                // Twitter handler mention configuration.
                // Sample Input:  `@colinodell`
                // Sample Output: `<a href="https://www.twitter.com/colinodell">@colinodell</a>`
                // Note: when registering more than one mention parser with the same prefix, the first mention parser to
                // successfully match and return a properly constructed Mention object (where the URL has been set) will be the
                // the mention parser that is used. In this example, the GitHub handle would actually match first because
                // there isn't any real validation to check whether https://www.github.com/colinodell exists. However, in
                // CMS applications, you could check whether its a local user first, then check Twitter and then GitHub, etc.
                'twitter_handle' => [
                    'prefix'    => '@',
                    'pattern'   => '[A-Za-z0-9_]{1,15}(?!\w)',
                    'generator' => 'https://twitter.com/%s',
                ],
            ],
            'smartpunct' => [
                'double_quote_opener' => '“',
                'double_quote_closer' => '”',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],
            // 'table_of_contents' => [
            //     'html_class'        => 'table-of-contents',
            //     'position'          => 'top',
            //     'style'             => 'bullet',
            //     'min_heading_level' => 1,
            //     'max_heading_level' => 6,
            //     'normalize'         => 'relative',
            //     'placeholder'       => null,
            // ],
        ];

        // Configure the Environment with all the CommonMark and GFM parsers/renderers
        // $environment = new Environment();
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new DefaultAttributesExtension());
        $environment->addExtension(new DescriptionListExtension());
        $environment->addExtension(new DisallowedRawHtmlExtension());
        $environment->addExtension(new ExternalLinkExtension());
        $environment->addExtension(new FootnoteExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        // $environment->addExtension(new InlinesOnlyExtension());
        $environment->addExtension(new MentionExtension());
        $environment->addExtension(new SmartPunctExtension());
        // $environment->addExtension(new StrikethroughExtension());
        // $environment->addExtension(new TableOfContentsExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new TaskListExtension());

        // $converter = new CommonMarkConverter($config, $environment);
        $converter = new MarkdownConverter($environment);
        $content = $converter->convertToHtml($markdown);

        return new CommonMarkProvider($content, $date);
    }
}
