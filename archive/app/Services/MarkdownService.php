<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\Block\Paragraph;

class MarkdownService
{
    public const CONFIG = [
        'APP_NAME' => 'app.name',
        'APP_URL' => 'app.url',
        'APP_FRONT_URL' => 'app.front_url',
        'APP_REPOSITORY_URL' => 'app.repository_url',
    ];

    public function __construct(
        public string $content,
        public string $date,
    ) {
    }

    public static function generate(string $path, bool $absolute = false): MarkdownService
    {
        if (! $absolute) {
            $path = resource_path("features/content/{$path}");
        }
        $markdown = File::get($path);
        $date = File::lastModified($path);
        $date = Carbon::createFromTimestamp($date)->toDateString();

        $markdown = self::replaceWithDotenv($markdown);

        return new MarkdownService($markdown, $date);
    }

    public static function replaceWithDotenv(string $markdown): string
    {
        foreach (self::CONFIG as $dotenv_key => $config_key) {
            $markdown = str_replace($dotenv_key, config($config_key), $markdown);
        }

        return $markdown;
    }

    public function convertToHtml()
    {
        $markdownConverter = new MarkdownConverter(environment: $this->getConfig());

        return $markdownConverter->convertToHtml($this->content);
    }

    public function getConfig(): Environment
    {
        $config = [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'external_link' => [
                'internal_hosts' => config('app.url'),
                'open_in_new_window' => true,
                'html_class' => 'external-link',
                'nofollow' => '',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
            'default_attributes' => [
                Heading::class => [
                    'class' => static function (Heading $node) {
                        if (1 === $node->getLevel()) {
                            return 'title-main';
                        }
                    },
                ],
                Table::class => [
                    'class' => 'table',
                ],
                Paragraph::class => [
                    'class' => ['word-wraping', 'font-sans'],
                ],
                Link::class => [
                    'class' => 'btn btn-link',
                    'target' => '_blank',
                ],
            ],
            'footnote' => [
                'backref_class' => 'footnote-backref',
                'backref_symbol' => '↩',
                'container_add_hr' => true,
                'container_class' => 'footnotes',
                'ref_class' => 'footnote-ref',
                'ref_id_prefix' => 'fnref:',
                'footnote_class' => 'footnote',
                'footnote_id_prefix' => 'fn:',
            ],
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => '',
            ],
            'mentions' => [
                // GitHub handler mention configuration.
                // Sample Input:  `@colinodell`
                // Sample Output: `<a href="https://www.github.com/colinodell">@colinodell</a>`
                'github_handle' => [
                    'prefix' => '@',
                    'pattern' => '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)',
                    'generator' => 'https://github.com/%s',
                ],
                // GitHub issue mention configuration.
                // Sample Input:  `#473`
                // Sample Output: `<a href="https://github.com/thephpleague/commonmark/issues/473">#473</a>`
                'github_issue' => [
                    'prefix' => '#',
                    'pattern' => '\d+',
                    'generator' => 'https://github.com/thephpleague/commonmark/issues/%d',
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
                    'prefix' => '@',
                    'pattern' => '[A-Za-z0-9_]{1,15}(?!\w)',
                    'generator' => 'https://twitter.com/%s',
                ],
            ],
            'smartpunct' => [
                'double_quote_opener' => '“',
                'double_quote_closer' => '”',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],
            'table_of_contents' => [
                'html_class' => 'table-of-contents',
                'position' => 'top',
                'style' => 'bullet',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'normalize' => 'relative',
                'placeholder' => null,
            ],
        ];

        return (new Environment($config))
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new GithubFlavoredMarkdownExtension())
            ->addExtension(new AttributesExtension())
            ->addExtension(new AutolinkExtension())
            ->addExtension(new DefaultAttributesExtension())
            ->addExtension(new DescriptionListExtension())
            ->addExtension(new DisallowedRawHtmlExtension())
            ->addExtension(new ExternalLinkExtension())
            ->addExtension(new FootnoteExtension())
            ->addExtension(new HeadingPermalinkExtension())
            // ->addExtension(new InlinesOnlyExtension())
            ->addExtension(new MentionExtension())
            ->addExtension(new SmartPunctExtension())
            // ->addExtension(new StrikethroughExtension())
            ->addExtension(new TableOfContentsExtension())
            ->addExtension(new TableExtension())
            ->addExtension(new TaskListExtension())
        ;
    }
}
