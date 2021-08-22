<?php

namespace App\Providers\Bookshelves;

use Route;
use DateTime;
use App\Models\Book;
use App\Enums\EntitiesEnum;
use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class OpdsProvider
{
    public function __construct(
        public string $version,
        public EntitiesEnum $entity,
        public string $route,
        public Collection | Model $data,
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
                if ($this->entity === EntitiesEnum::BOOK()) {
                    $templateEntry = $this->entryBook($entry);
                } else {
                    $templateEntry = $this->entry($entry);
                }

                array_push($entries, $templateEntry);
            }
        } elseif ($this->data instanceof Model) {
            $templateEntry = $this->entry($this->data);
            $entries = $templateEntry;
        }

        return $entries;
    }

    public function template(string $title = null)
    {
        $id = Str::slug(config('app.name'));
        $id .= ':'.Str::slug($this->entity->label);
        $id .= $title ? ':'.Str::slug($title) : null;

        $feed_title = config('app.name').' OPDS';
        $feed_title .= ': '.ucfirst(strtolower($this->entity->label)) ?? null;
        $feed_title .= $title !== null ? ': '.$title : null;

        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        
        $feed_links = [
            'xmlns:app'        => 'http://www.w3.org/2007/app',
            'xmlns:opds'       => 'http://opds-spec.org/2010/catalog',
            'xmlns:opensearch' => 'http://a9.com/-/spec/opensearch/1.1/',
            'xmlns:odl'        => 'http://opds-spec.org/odl',
            'xmlns:dcterms'    => 'http://purl.org/dc/terms/',
            'xmlns'            => 'http://www.w3.org/2005/Atom',
            'xmlns:thr'        => 'http://purl.org/syndication/thread/1.0',
            'xmlns:xsi'        => 'http://www.w3.org/2001/XMLSchema-instance',
        ];

        $feed = (array) [
            'id'              => $id,
            '__custom:link:1' => [
                '_attributes' => [
                    'rel'   => 'start',
                    'href'  => route('opds.feed', ['version' => $this->version]),
                    'type'  => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'Home',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'rel'   => 'self',
                    'href'  => $this->route,
                    'type'  => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'self',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'rel'   => 'search',
                    'href'  => route('opds.feed', ['version' => $this->version]),
                    'type'  => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'Search here',
                ],
            ],
            'title'   => $feed_title,
            'updated' => $date,
            'author'  => [
                'name' => config('app.name'),
                'uri'  => config('app.url'),
            ],
            'entry' => $this->feed(),
        ];

        $template = ArrayToXml::convert($feed, [
            'rootElementName' => 'feed',
            '_attributes'     => $feed_links,
        ], true, 'UTF-8');

        return $template;
    }

    public function entry(object $entry): array
    {
        $app = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $title = $entry->title ?? "$entry->lastname $entry->firstname";
        $description = $entry->content_opds ?? $entry->content;
        $route = $entry->show_link_opds ?? $entry->route;

        $template = [
            'title'   => $title,
            'updated' => $date,
            'id'      => $app.':'.Str::slug($this->entity->label).':'.Str::slug($title),
            'content' => [
                '_attributes' => [
                    'type' => 'text',
                ],
                '_value' => (string) $description,
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
                    'rel'  => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
        ];

        return $template;
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
        foreach ($tags as $key => $tag) {
            array_push($categories, [
                '_attributes' => [
                    'term'  => $tag->name,
                    'label' => $tag->name,
                ]
            ]);
        }

        $template = [
            'title'   => $book->title,
            'updated' => $date,
            'id'      => $id,
            'content' => [
                '_attributes' => [
                    'type' => 'text/html',
                ],
                '_value' => $book->description,
            ],
            '__custom:link:1' => [
                '_attributes' => [
                    'href' => $book->show_link_opds,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'href' => $book->cover_original,
                    'type' => 'image/png',
                    'rel'  => 'http://opds-spec.org/image',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'href' => $book->cover_thumbnail,
                    'type' => 'image/png',
                    'rel'  => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
            '__custom:link:4' => [
                '_attributes' => [
                    'href'  => $book->download_link,
                    'type'  => 'application/epub+zip',
                    'rel'   => 'http://opds-spec.org/acquisition',
                    'title' => 'EPUB'
                ],
            ],
            'category' => $categories,
            'author'   => [
                'name' => $book->authors[0]->name,
                'uri'  => $book->authors[0]->show_link_opds
            ],
            'dcterms:issued'   => $book->date,
            'published'        => $book->date,
            'volume'           => $book->volume,
            'dcterms:language' => $book->language->name,
        ];

        return $template;
    }
}
