<?php

return [
    'mails' => [
        'to'   => 'info@bookshelves.com',
        'from' => 'noreplyinfo@bookshelves.com',
    ],
    'cover_extension'              => env('IMAGE_FORMAT', 'webp'),
    'converted_pictures_directory' => 'glide',
    'admin'                        => [
        'email'    => env('ADMIN_EMAIL', 'admin@mail.com'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],
    'authors' => [
        // For all ebooks: if you have authors' names like lastname_firstname
        // set to false to reverse
        'order_firstname_lastname'      => env('AUTHORS_ORDER_FIRSTNAME_LASTNAME', true),
        'skip_homonyms'                 => env('AUTHORS_SKIP_HOMONYMS', false)
    ],
    'langs' => [
        'fr'      => 'French',
        'en'      => 'English',
    ],
    // From Wikipedia: https://en.wikipedia.org/wiki/List_of_writing_genres.
    // Any tag add here will be used as 'genre'
    'genres' => [
        'Action & adventures',
        'Crime & mystery',
        'Fantasy',
        'Horror',
        'Romance',
        'Science fiction',
    ],

    'forbidden_tags' => [
        'SF',
        'General',
    ],

    'converted_tags' => [
        'Action & Adventure' => 'Action & adventures',
    ],
    
    'navigation'=> [
        'admin' => [
            'route'    => 'admin',
            'title'    => 'Back-office',
            'icon'     => 'lock-open',
            'external' => true
        ],
        'user' => [
            [
                'route'    => 'features',
                'href'     => false,
                'title'    => 'Home',
                'icon'     => 'home',
                'external' => false
            ],
            [
                'route'    => 'features.opds.index',
                'href'     => false,
                'title'    => 'OPDS',
                'icon'     => 'feed',
                'external' => false
            ],
            [
                'route'    => 'features.catalog.index',
                'href'     => false,
                'title'    => 'Catalog',
                'icon'     => 'catalog',
                'external' => false
            ],
            [
                'route'    => 'features.webreader.index',
                'href'     => false,
                'title'    => 'Webreader',
                'icon'     => 'ereader',
                'external' => false
            ],
        ],
        'dev' => [
            [
                'route'    => 'features.wiki.index',
                'href'     => false,
                'title'    => 'Wiki',
                'icon'     => 'wiki',
                'external' => false
            ],
            [
                'route'    => 'features.roadmap.index',
                'href'     => false,
                'title'    => 'Roadmap',
                'icon'     => 'map',
                'external' => false
            ],
            [
                'route'    => 'scribe',
                'href'     => false,
                'title'    => 'API doc',
                'icon'     => 'api',
                'external' => true
            ],
            [
                'route'    => false,
                'href'     => env('APP_REPOSITORY', 'https://gitlab.com/ewilan-riviere/bookshelves-back'),
                'title'    => 'Repository',
                'icon'     => 'git-branch',
                'external' => true
            ],
        ]
    ]
];
