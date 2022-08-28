<?php

namespace App\Engines\OpdsEngine;

use App\Enums\BookFormatEnum;
use App\Enums\EntityEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Entity;
use App\Models\Serie;
use App\Models\TagExtend;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;

class XmlResponse
{
    public function __construct(
        public string $version,
        public EntityEnum $entity,
        public string $route,
        public Collection|Model $data,
    ) {
    }

    public function feed(): array
    {
        $id = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $entries = [];
        if ($this->data instanceof Collection) {
            foreach ($this->data as $key => $entry) {
                if (EntityEnum::book === $this->entity) {
                    /** @var Book $entry */
                    $template_entry = $this->entryBook($entry);
                } elseif (EntityEnum::entity === $this->entity) {
                    /** @var Author|Book|Serie $entry */
                    $template_entry = $this->entryEntity($entry);
                } else {
                    $template_entry = $this->entry($entry);
                }

                array_push($entries, $template_entry);
            }
        } elseif ($this->data instanceof Book) {
            $entries = $this->entryBook($this->data);
        }

        return $entries;
    }

    public function template(string $title = null)
    {
        $id = Str::slug(config('app.name'));
        $id .= ':'.Str::slug($this->entity->value);
        $id .= $title ? ':'.Str::slug($title) : null;

        $feed_title = config('app.name').' OPDS';
        $feed_title .= ': '.ucfirst(strtolower($this->entity->value));
        $feed_title .= null !== $title ? ': '.$title : null;

        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $feed_links = [
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
                    'href' => route('opds.version', ['version' => $this->version]),
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'Home',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'rel' => 'self',
                    'href' => $this->route,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'self',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'rel' => 'search',
                    'href' => route('opds.search', ['version' => $this->version]),
                    'type' => 'application/opensearchdescription+xml',
                    'title' => 'Search here',
                ],
            ],
            'title' => $feed_title,
            'updated' => $date,
            'author' => [
                'name' => config('app.name'),
                'uri' => config('app.url'),
            ],
            'entry' => $this->feed(),
        ];

        return ArrayToXml::convert(
            array: $feed,
            rootElement: [
                'rootElementName' => 'feed',
                '_attributes' => $feed_links,
            ],
            replaceSpacesByUnderScoresInKeyNames: true,
            xmlEncoding: 'UTF-8'
        );
    }

    public function entry(object $entry): array
    {
        $app = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $title = $entry->title ?? "{$entry->lastname} {$entry->firstname}";
        $description = $entry->content_opds ?? $entry->content;
        $route = $entry->opds_link ?? $entry->route;

        return [
            'title' => $title,
            'updated' => $date,
            'id' => $app.':'.Str::slug($this->entity->value).':'.Str::slug($title),
            'summary' => [
                '_attributes' => [
                    'type' => 'text',
                ],
                '_value' => (string) "{$title}, {$description}",
            ],
            '__custom:link:1' => [
                '_attributes' => [
                    'href' => $route,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'href' => $entry->cover_thumbnail ?? null,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
        ];
    }

    public function entryBook(Book $book)
    {
        $app = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $id = $app.':books:';
        $id .= $book->serie ? Str::slug($book->serie->title).':' : null;
        $id .= $book->slug;

        $categories = [];
        $tags = $book->tags;

        /** @var TagExtend $tag */
        foreach ($tags as $key => $tag) {
            array_push($categories, [
                '_attributes' => [
                    'term' => $tag->name,
                    'label' => $tag->name,
                ],
            ]);
        }

        $authors = [];
        foreach ($book->authors as $key => $author) {
            array_push(
                $authors,
                [
                    'name' => $author->name,
                    'uri' => $author->opds_link,
                ],
            );
        }

        return [
            'title' => $book->title,
            'updated' => $date,
            'id' => $id,
            'content' => [
                '_attributes' => [
                    'type' => 'text/html',
                ],
                '_value' => $book->description,
            ],
            '__custom:link:1' => [
                '_attributes' => [
                    'href' => $book->opds_link,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'href' => $book->cover_original,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'href' => $book->cover_thumbnail,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
            ...$this->formats($book),
            'category' => $categories,
            'author' => $authors,
            'dcterms:issued' => $book->released_on,
            'published' => $book->released_on,
            'volume' => $book->volume,
            'dcterms:language' => $book->language->name,
        ];
    }

    public function entryEntity(Book|Author|Serie $entity)
    {
        $app = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        /** @var Entity $entity */
        $id = $app.':books:';
        $id .= $entity->serie ? Str::slug($entity->serie->title).':' : null;
        $id .= $entity->slug;

        $authors = [];
        if ($entity->authors) {
            foreach ($entity->authors as $key => $author) {
                array_push(
                    $authors,
                    [
                        'name' => $author->name,
                        'uri' => $author->opds_link,
                    ],
                );
            }
        }

        return [
            'title' => $entity->title ?? $entity->name,
            'updated' => $date,
            'id' => $id,
            'type' => $entity->type?->i18n(),
            'entity' => Entity::getEntity($entity),
            '__custom:link:1' => [
                '_attributes' => [
                    'href' => $entity->opds_link,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'href' => $entity->cover_original,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'href' => $entity->cover_thumbnail,
                    'type' => 'image/png',
                    'rel' => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
            // ...$this->formats($entity),
            'author' => $authors,
            'volume' => $entity->volume,
            'dcterms:language' => $entity->language?->name,
        ];
    }

    public function formats(Book $book): array
    {
        $list = [];
        $i = 4;
        foreach (BookFormatEnum::toValues() as $format) {
            if ($book->files[$format]) {
                if (null !== $book->files_list[$format]) {
                    $list['__custom:link:'.$i] = [
                        '_attributes' => [
                            'href' => $book->files_list[$format]->url,
                            'type' => 'application/epub+zip',
                            'rel' => 'http://opds-spec.org/acquisition',
                            'title' => 'EPUB',
                        ],
                    ];
                    ++$i;
                }
            }
        }

        return $list;
    }

    public static function search(string $version): string
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $feed_links = [
            'xmlns' => 'http://a9.com/-/spec/opensearch/1.1/',
        ];
        $app = config('app.name');

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
                    'template' => route('opds.search', ['version' => $version]),
                    'type' => 'application/opensearchdescription+xml',
                    'rel' => 'self',
                ],
            ],
            '__custom:Url:4' => [
                '_attributes' => [
                    'template' => urldecode(route('opds.search', ['version' => $version, 'q' => '{searchTerms}'])),
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
}
