<?php

return [
    // Authentication.
    'admin' => [
        'email' => env('BOOKSHELVES_ADMIN_EMAIL', 'admin@mail.com'),
        'password' => env('BOOKSHELVES_ADMIN_PASSWORD', 'password'),
    ],
    // General.
    'cover_extension' => env('BOOKSHELVES_COVER_FORMAT', 'webp'),
    // Authors.
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
     * ParserEngine will create Language with translations from Locale
     */
    'langs' => explode(',', env('BOOKSHELVES_LANGS', 'fr,en')),
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
    // Navigation.
    'navigation' => [
        'features' => [
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
        ],
        'footer' => [
            [
                'route' => 'admin.login',
                'href' => false,
                'title' => 'Admin',
                'description' => '',
                // 'icon' => 'lock-open',
                'external' => true,
            ],
            [
                'route' => 'scribe',
                'href' => false,
                'title' => 'API documentation',
                // 'icon' => 'api',
                'external' => true,
            ],
            [
                'route' => false,
                'href' => config('app.documentation_url'),
                'title' => 'Documentation',
                'description' => '',
                // 'icon' => 'wiki',
                'external' => true,
            ],
            [
                'route' => false,
                'href' => config('app.repository_url'),
                'title' => 'Git',
                'description' => '',
                // 'icon' => 'git',
                'external' => true,
            ],
        ],
    ],
];
