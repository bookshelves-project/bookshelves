<?php

return [
    /*
     * Authentication.
     */
    'admin' => [
        'email' => env('BOOKSHELVES_ADMIN_EMAIL', 'admin@mail.com'),
        'password' => env('BOOKSHELVES_ADMIN_PASSWORD', 'password'),
    ],
    /*
     * General.
     */
    'cover_extension' => env('BOOKSHELVES_COVER_FORMAT', 'webp'),
    'converted_pictures_directory' => 'glide',
    /*
     * Authors.
     */
    'authors' => [
        // Depends of your order of sort for authors
        // true: `Victor Hugo` will be `firstname`: "Victor", `lastname`: "Hugo"
        // false: `Hugo Victor` will be `firstname`: "Victor", `lastname`: "Hugo"
        'order_natural' => env('BOOKSHELVES_AUTHOR_ORDER_NATURAL', true),
        // true: `Victor Hugo` and `Hugo Victor` will be merge
        // false: two Author will be created
        'detect_homonyms' => env('BOOKSHELVES_AUTHOR_DETECT_HOMONYMS', true),
    ],
    /*
     * Langs
     * If a lang is not here, ParserEngine will create lang from meta
     * Like a book in English with Calibre, meta will be `en`, the engine create `En` lang if not exist.
     */
    'langs' => explode(',', env('BOOKSHELVES_LANGS', 'fr.French,en.English')),
    /*
     * Tags
     * From Wikipedia: https://en.wikipedia.org/wiki/List_of_writing_genres.
     * Any tag add here will be used as 'genre'.
     */
    'tags' => [
        'genres_list' => explode(',', env('BOOKSHELVES_TAGS_GENRES', 'Action & adventures,Crime & mystery,Fantasy,Horror,Romance,Science fiction')),
        'forbidden' => explode(',', env('BOOKSHELVES_TAGS_FORBIDDEN', 'SF,General')),
        'converted' => [
            'Action & Adventure' => 'Action & adventures',
        ],
    ],
    /*
     * Navigation.
     */
    'navigation' => [
        'admin' => [
            'route' => 'admin',
            'title' => 'Back-office',
            'icon' => 'lock-open',
            'external' => true,
        ],
        'user' => [
            [
                'route' => 'features',
                'href' => false,
                'title' => 'Home',
                'icon' => 'home',
                'external' => false,
            ],
            [
                'route' => 'features.opds.index',
                'href' => false,
                'title' => 'OPDS',
                'icon' => 'feed',
                'external' => false,
            ],
            [
                'route' => 'features.catalog.index',
                'href' => false,
                'title' => 'Catalog',
                'icon' => 'catalog',
                'external' => false,
            ],
            [
                'route' => 'features.webreader.index',
                'href' => false,
                'title' => 'Webreader',
                'icon' => 'ereader',
                'external' => false,
            ],
        ],
        'dev' => [
            [
                'route' => 'features.wiki.index',
                'href' => false,
                'title' => 'Wiki',
                'icon' => 'wiki',
                'external' => false,
            ],
            [
                'route' => 'features.roadmap.index',
                'href' => false,
                'title' => 'Roadmap',
                'icon' => 'map',
                'external' => false,
            ],
            [
                'route' => 'scribe',
                'href' => false,
                'title' => 'API doc',
                'icon' => 'api',
                'external' => true,
            ],
            [
                'route' => false,
                'href' => env('APP_REPOSITORY', 'https://gitlab.com/ewilan-riviere/bookshelves-back'),
                'title' => 'Repository',
                'icon' => 'git-branch',
                'external' => true,
            ],
        ],
    ],
];
