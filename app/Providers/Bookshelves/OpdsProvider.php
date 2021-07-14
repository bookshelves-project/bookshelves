<?php

namespace App\Providers\Bookshelves;

use Route;
use DateTime;
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class OpdsProvider
{
    public static function feed(string $entity, object | array $data, string $endpoint, string $route)
    {
        $id = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $entries = [];
        if ($data instanceof Collection || 'array' === gettype($data)) {
            foreach ($data as $key => $entry) {
                // home page with feed
                if ('feed' === $endpoint) {
                    $templateEntry = self::entry(
                        key: $entry->key,
                        title: $entry->title,
                        content: $entry->content,
                        route: route($entry->route, ['version' => 'v1.2']),
                        picture: config('app.url')."/storage/assets/$entry->key.png"
                    );
                }
                dd($entity);
                // collection
                $templateEntry = self::entryBook(
                    key: "$endpoint:$entry->slug",
                    book: $entry,
                );
                

                array_push($entries, $templateEntry);
            }
        } elseif ($data instanceof Model) {
            // resource
            $templateEntry = self::entry(
                key: "$endpoint:$data->slug",
                title: $data->title ?? "$data->lastname $data->firstname",
                content: ucfirst($endpoint),
                route: $data->show_link_opds,
                picture: $data->image_thumbnail
            );

            array_push($entries, $templateEntry);
        }

        return $entries;
    }

    public static function template(string $entity, object | array $data, string $endpoint, string $route, string $id = null, string $title = null)
    {
        if (! $id) {
            $id = Str::slug(config('app.name')).':catalog';
        } else {
            $id = Str::slug(config('app.name')).':catalog:'.$id;
        }

        if (! $title) {
            $title = config('app.name').' OPDS';
        }

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
        $template = ArrayToXml::convert([
            'id'              => $id,
            '__custom:link:1' => [
                '_attributes' => [
                    'rel'   => 'self',
                    'href'  => $route,
                    'type'  => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'Home',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'rel'   => 'start',
                    'href'  => route('opds', ['version' => 'v1.2']),
                    'type'  => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                    'title' => 'Feed',
                ],
            ],
            'title'   => $title,
            'updated' => $date,
            'author'  => [
                'name' => config('app.name'),
                'uri'  => config('app.url'),
            ],
            'entry' => OpdsProvider::feed(entity: $entity, endpoint: $endpoint, data: $data, route: $route),
        ], [
            'rootElementName' => 'feed',
            '_attributes'     => $feed_links,
        ], true, 'UTF-8');

        return $template;
    }

    public static function entry(string $key, string $title, string $content, string $route, string $picture)
    {
        $app = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $template = [
            'title'   => $title,
            'updated' => $date,
            'id'      => $app.':'.$key,
            'content' => [
                '_attributes' => [
                    'type' => 'text',
                ],
                '_value' => $content,
            ],
            '__custom:link:1' => [
                '_attributes' => [
                    'href' => $route,
                    'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
                ],
            ],
            '__custom:link:2' => [
                '_attributes' => [
                    'href' => $picture,
                    'type' => 'image/png',
                    'rel'  => 'http://opds-spec.org/image/thumbnail',
                ],
            ],
        ];

        return $template;
    }

    public static function entryBook(
        string $key,
        Book $book,
    ) {
        $app = strtolower(config('app.name'));
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

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
            'id'      => $app.':'.$key,
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
                    'href' => $book->image_original,
                    'type' => 'image/png',
                    'rel'  => 'http://opds-spec.org/image',
                ],
            ],
            '__custom:link:3' => [
                '_attributes' => [
                    'href' => $book->image_thumbnail,
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
            'dcterms:language' => $book->language->name,
        ];

        return $template;
    }
}
