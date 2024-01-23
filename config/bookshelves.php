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
        // When you create a new Author, Bookshelves will try to find informations from Wikipedia
        // By default, it will search with full name like `Victor Hugo`
        // If `BOOKSHELVES_AUTHOR_WIKIPEDIA_EXACT` is true, Bookshelves will accept only results where Wikipedia title page is exactly the same as Author name
        // If `BOOKSHELVES_AUTHOR_WIKIPEDIA_EXACT` is false, Bookshelves will accept results where Wikipedia title page is not exactly the same as Author name
        'wikipedia_exact' => env('BOOKSHELVES_AUTHOR_WIKIPEDIA_EXACT', true),
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

    'library' => [
        'books' => env('BOOKSHELVES_LIBRARY_BOOKS', false),
        'comics' => env('BOOKSHELVES_LIBRARY_COMICS', false),
        'mangas' => env('BOOKSHELVES_LIBRARY_MANGAS', false),
        'audiobooks' => env('BOOKSHELVES_LIBRARY_AUDIOBOOKS', false),
    ],

    'image' => [
        'disk' => env('BOOKSHELVES_IMAGE_DISK', 'covers'),
        'collection' => env('BOOKSHELVES_IMAGE_COLLECTION', 'covers'),
        'driver' => env('BOOKSHELVES_IMAGE_DRIVER', 'gd'),
        'format' => env('BOOKSHELVES_IMAGE_FORMAT', 'avif'),
        'max_height' => env('BOOKSHELVES_IMAGE_MAX_HEIGHT', 1600),
        'conversion' => env('BOOKSHELVES_IMAGE_CONVERSION', true),
        'cover' => [
            'standard' => [
                'width' => 533,
                'height' => 800,
            ],
            'thumbnail' => [
                'width' => 266,
                'height' => 400,
            ],
            'social' => [
                'width' => 1200,
                'height' => 600,
            ],
        ],
    ],
];
