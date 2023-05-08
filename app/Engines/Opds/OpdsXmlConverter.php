<?php

namespace App\Engines\Opds;

use App\Engines\Opds\Config\OpdsConfigApp;
use App\Engines\Opds\Config\OpdsEntry;
use App\Engines\Opds\Config\OpdsEntryBook;
use App\Engines\OpdsEngine;
use DateTime;
use Spatie\ArrayToXml\ArrayToXml;
use Transliterator;

class OpdsXmlConverter
{
    protected function __construct(
        protected OpdsConfigApp $app,
    ) {
    }

    /**
     * @param  array<OpdsEntry|OpdsEntryBook>  $entries
     */
    public static function make(OpdsConfigApp $app, array $entries, string $title = 'feed'): string
    {
        $self = new self($app);

        $id = self::slug($app->name);
        $id .= ':'.self::slug($title);

        $feedTitle = "{$app->name} OPDS";
        $feedTitle .= ': '.ucfirst(strtolower($title));

        $date = $app->updated ?? new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $specs = [
            'xmlns:app' => 'http://www.w3.org/2007/app',
            'xmlns:opds' => 'http://opds-spec.org/2010/catalog',
            'xmlns:opensearch' => 'http://a9.com/-/spec/opensearch/1.1/',
            'xmlns:odl' => 'http://opds-spec.org/odl',
            'xmlns:dcterms' => 'http://purl.org/dc/terms/',
            'xmlns' => 'http://www.w3.org/2005/Atom',
            'xmlns:thr' => 'http://purl.org/syndication/thread/1.0',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        ];

        $feed = [
            'id' => $id,
            '__custom:link:1' => [
                '_attributes' => [
                    'rel' => 'start',
                    'href' => $app->startUrl,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'Home',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'rel' => 'self',
                    'href' => OpdsEngine::currentUrl(),
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'self',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'rel' => 'search',
                    'href' => $app->searchUrl,
                    'type' => 'application/opensearchdescription+xml',
                    'title' => 'Search here',
                ],
            ],
            'title' => $feedTitle,
            'updated' => $date,
        ];

        if ($app->author) {
            $feed['author'] = [
                'name' => $app->author,
                'uri' => $app->authorUrl,
            ];
        }

        foreach ($entries as $entry) {
            if ($entry instanceof OpdsEntryBook) {
                $feed['entry'][] = $self->entryBook($entry);
            } else {
                $feed['entry'][] = $self->entry($entry);
            }
        }

        return ArrayToXml::convert(
            array: $feed,
            rootElement: [
                'rootElementName' => 'feed',
                '_attributes' => $specs,
            ],
            replaceSpacesByUnderScoresInKeyNames: true,
            xmlEncoding: 'UTF-8'
        );
    }

    public function entry(OpdsEntry $entry): array
    {
        $app = self::slug($this->app->name);

        return [
            'title' => $entry->title,
            'updated' => $entry->updated,
            'id' => "{$app}:{$entry->id}",
            'summary' => [
                '_attributes' => [
                    'type' => 'text',
                ],
                '_value' => $entry->summary,
            ],
            '__custom:link:1' => [
                '_attributes' => [
                    'href' => $entry->route,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'href' => $entry->media ?? null,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
        ];
    }

    public function entryBook(OpdsEntryBook $entry): array
    {
        $app = self::slug($this->app->name);
        $id = $app.':books:';
        $id .= $entry->serie ? self::slug($entry->serie).':' : null;
        $id .= self::slug($entry->title);

        $authors = [];
        $categories = [];

        foreach ($entry->categories as $item) {
            $categories[] = [
                '_attributes' => [
                    'term' => $item,
                    'label' => $item,
                ],
            ];
        }

        foreach ($entry->authors as $item) {
            $authors[] = [
                'name' => $item->name,
                'uri' => $item->uri,
            ];
        }

        return [
            'title' => $entry->title,
            'updated' => $entry->updated,
            'id' => $id,
            'content' => [
                '_attributes' => [
                    'type' => 'text/html',
                ],
                '_value' => $entry->content,
            ],
            '__custom:link:1' => [
                '_attributes' => [
                    'href' => $entry->routeSelf,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'href' => $entry->media,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'href' => $entry->mediaThumbnail,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
            '__custom:link:4' => [
                '_attributes' => [
                    'href' => $entry->routeDownload,
                    'type' => 'application/epub+zip',
                    'rel' => 'http://opds-spec.org/acquisition',
                    'title' => 'EPUB',
                ],
            ],
            'category' => $categories,
            'author' => $authors,
            'dcterms:issued' => $entry->published->format('Y-m-d'),
            'published' => $entry->published,
            'volume' => $entry->volume,
            'dcterms:language' => $entry->language,
        ];
    }

    public static function search(OpdsConfigApp $app): string
    {
        $self = new self($app);
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $feed_links = [
            'xmlns' => 'http://a9.com/-/spec/opensearch/1.1/',
        ];
        $app = self::slug($self->app->name);

        $feed = [
            'ShortName' => [
                '_value' => $app,
            ],
            'Description' => [
                '_value' => "OPDS search engine {$app}",
            ],
            'InputEncoding' => [
                '_value' => 'UTF-8',
            ],
            'OutputEncoding' => [
                '_value' => 'UTF-8',
            ],
            'Image' => [
                '_attributes' => [
                    'width' => '16',
                    'height' => '16',
                    'type' => 'image/x-icon',
                ],
                '_value' => config('app.url').'/favicon.ico',
            ],
            // '__custom:Url:1' => [
            //     '_attributes' => [
            //         // 'template' => 'http://gallica.bnf.fr/services/engine/search/sru?operation=searchRetrieve&version=1.2&query=(gallica%20all%20%22{searchTerms}%22)',
            //         'template' => route('opds.search', ['version' => $version, 'q' => '{searchTerms}']),
            //         'type' => 'text/html',
            //     ],
            // ],
            // '__custom:Url:2' => [
            //     '_attributes' => [
            //         // 'template' => 'http://gallica.bnf.fr/services/engine/search/openSearchSuggest?typedoc=&query={searchTerms}',
            //         'template' => route('opds.search', ['version' => $version, 'q' => '{searchTerms}']),
            //         'type' => 'application/x-suggestions+json',
            //         'rel' => 'suggestions',
            //     ],
            // ],
            '__custom:Url:3' => [
                '_attributes' => [
                    // 'template' => 'http://gallica.bnf.fr/assets/static/opensearchdescription.xml',
                    // 'template' => route('opds.search', ['version' => $version]),
                    'type' => 'application/opensearchdescription+xml',
                    'rel' => 'self',
                ],
            ],
            '__custom:Url:4' => [
                '_attributes' => [
                    // 'template' => urldecode(route('opds.search', ['version' => $version, 'q' => '{searchTerms}'])),
                    'type' => 'application/atom+xml',
                ],
            ],
            'Query' => [
                '_attributes' => [
                    'role' => 'example',
                    'searchTerms' => 'robot',
                ],
            ],
            'Developer' => [
                '_value' => "{$app} Team",
            ],
            'Attribution' => [
                '_value' => "Search data {$app}",
            ],
            'SyndicationRight' => [
                '_value' => 'open',
            ],
            'AdultContent' => [
                '_value' => 'false',
            ],
            'Language' => [
                '_value' => '*',
            ],
        ];

        return ArrayToXml::convert(
            array: $feed,
            rootElement: [
                'rootElementName' => 'OpenSearchDescription',
                '_attributes' => $feed_links,
            ],
            replaceSpacesByUnderScoresInKeyNames: true,
            xmlEncoding: 'UTF-8'
        );
    }

    /**
     * Laravel export
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  array<string, string>  $dictionary
     */
    public static function slug(?string $title, string $separator = '-', array $dictionary = ['@' => 'at']): ?string
    {
        if (! $title) {
            return null;
        }

        $transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);
        $title = $transliterator->transliterate($title);

        // Convert all dashes/underscores into separator
        $flip = $separator === '-' ? '_' : '-';

        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

        // Replace dictionary words
        foreach ($dictionary as $key => $value) {
            $dictionary[$key] = $separator.$value.$separator;
        }

        $title = str_replace(array_keys($dictionary), array_values($dictionary), $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace
        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', strtolower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        return trim($title, $separator);
    }
}
