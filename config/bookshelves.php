<?php

return [
    'mails' => [
        'to'   => 'info@bookshelves.com',
        'from' => 'noreplyinfo@bookshelves.com',
    ],
    'cover_extension'              => 'webp',
    'converted_pictures_directory' => 'glide',
    'admin'                        => [
        'email'    => env('ADMIN_EMAIL', 'admin@mail.com'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],
    'authors' => [
        // For all ebooks: if you have authors' names like lastname_firstname
        // set to false to reverse
        'firstname_lastname' => true,
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
                'route'    => 'opds.index',
                'title'    => 'OPDS',
                'icon'     => 'feed',
                'external' => false
            ],
            [
                'route'    => 'catalog.index',
                'title'    => 'Catalog',
                'icon'     => 'book-open',
                'external' => false
            ],
            [
                'route'    => 'webreader.index',
                'title'    => 'Webreader',
                'icon'     => 'ereader',
                'external' => false
            ],
        ],
        'dev' => [
            [
                'route'    => 'wiki.index',
                'title'    => 'Wiki',
                'icon'     => 'wiki',
                'external' => false
            ],
            [
                'route'    => 'scribe',
                'title'    => 'API doc',
                'icon'     => 'api',
                'external' => true
            ]
        ]
    ]
];
