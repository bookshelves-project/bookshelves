<?php

namespace App\Utils;

class FrontNavigation
{
    public static function getFeaturesNavigation()
    {
        return [
            [
                'route' => false,
                'href' => config('app.front_url'),
                'title' => config('app.name'),
                'description' => 'Main website',
                'icon' => 'logo',
                'external' => true,
            ],
            [
                'route' => 'front.opds',
                'href' => false,
                'title' => 'OPDS',
                'description' => 'Open Publication Distribution System allow you to connect an application with OPDS feature to current feed. You can have all Ebooks on your own app!',
                'icon' => 'feed',
                'external' => false,
            ],
            [
                'route' => 'front.catalog',
                'href' => false,
                'title' => 'Catalog',
                'description' => 'With a very basic interface to allow an eReader browser to dowload any eBook without computer. Easy download & read when you travel.',
                'icon' => 'catalog',
                'external' => false,
            ],
            [
                'route' => 'front.webreader',
                'href' => false,
                'title' => 'Webreader',
                'description' => 'Read an eBook directly into your browser, works on desktop or smartphone. Useful to discover a new book!',
                'icon' => 'ereader',
                'external' => false,
            ],
        ];
    }

    public static function getDeveloperNavigation()
    {
        return [
            [
                'route' => 'filament.pages.dashboard',
                'href' => false,
                'title' => 'Admin',
                'description' => '',
                'external' => true,
            ],
            [
                'route' => false,
                'href' => config('app.url').'/api/documentation',
                'title' => 'API docs',
                'external' => true,
            ],
            [
                'route' => false,
                'href' => config('bookshelves.documentation_url'),
                'title' => 'Documentation',
                'description' => '',
                'external' => true,
            ],
            [
                'route' => false,
                'href' => config('bookshelves.repository_url'),
                'title' => 'Git',
                'description' => '',
                'external' => true,
            ],
        ];
    }
}
