<?php

return [
    'super_admin' => [
        'email' => env('BOOKSHELVES_SUPER_ADMIN_EMAIL', 'superadmin@example.com'),
        'password' => env('BOOKSHELVES_SUPER_ADMIN_PASSWORD', 'password'),
    ],

    'analyzer' => [
        'engine' => env('BOOKSHELVES_ANALYZER_ENGINE', 'native'), // native, scanner
        'debug' => env('BOOKSHELVES_ANALYZER_DEBUG', false),
    ],

    // 'tmdb' => [
    //     'api_key' => env('BOOKSHELVES_TMDB_API_KEY'),
    // ],

    // 'download_limit' => env('BOOKSHELVES_DOWNLOAD_LIMIT', 5),

    // 'verbose' => env('BOOKSHELVES_VERBOSE', false),

    // 'notification' => [
    //     'discord' => env('BOOKSHELVES_NOTIFICATION_DISCORD', false),
    // ],

    'slug' => \Illuminate\Support\Str::slug(env('APP_NAME', 'Bookshelves')),
    'repository_url' => env('BOOKSHELVES_REPOSITORY_URL', 'https://github.com/bookshelves-project'),
    'documentation_url' => env('BOOKSHELVES_DOCUMENTATION_URL', 'https://bookshelves-documentation.netlify.app'),
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
    'parser' => [
        'name' => env('BOOKSHELVES_PARSER_NAME', false),
    ],
    'pdf' => [
        'cover' => env('BOOKSHELVES_PDF_COVER', true),
    ],
    /*
     * Langs
     * ParserEngine will create Language with translations from Locale
     */
    'langs' => explode(',', env('BOOKSHELVES_LANGS', 'fr,en')), // deprecated
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

    'directory' => env('BOOKSHELVES_DIRECTORY', 'storage/app/data'),
    'local' => [
        'copy' => env('BOOKSHELVES_LOCAL_COPY', false),
        'cover' => env('BOOKSHELVES_LOCAL_COVER', true),
    ],

    'image' => [
        'driver' => env('BOOKSHELVES_IMAGE_DRIVER', 'gd'),
        'format' => env('BOOKSHELVES_IMAGE_FORMAT', 'avif'),
        'conversion' => env('BOOKSHELVES_IMAGE_CONVERSION', true),
        'cover' => [
            'standard' => [
                'width' => 100,
                'height' => 160,
            ],
            'thumbnail' => [
                'width' => 200,
                'height' => 320,
            ],
            'social' => [
                'width' => 600,
                'height' => 300,
            ],
        ],
    ],
];
