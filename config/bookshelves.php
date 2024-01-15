<?php

return [
    'super_admin' => [
        'email' => env('BOOKSHELVES_SUPER_ADMIN_EMAIL', 'superadmin@example.com'),
        'password' => env('BOOKSHELVES_SUPER_ADMIN_PASSWORD', 'password'),
    ],

    'tmdb' => [
        'api_key' => env('BOOKSHELVES_TMDB_API_KEY'),
    ],

    'download_limit' => env('BOOKSHELVES_DOWNLOAD_LIMIT', 5),

    'verbose' => env('BOOKSHELVES_VERBOSE', false),

    'analyzer' => [
        'engine' => env('BOOKSHELVES_ANALYZER_ENGINE', 'native'), // native, scanner
        'metadata' => env('BOOKSHELVES_ANALYZER_METADATA', 'native'), // native, scanner, ffprobe
        'limit' => env('BOOKSHELVES_ANALYZER_LIMIT', false), // false or integer
    ],

    'notification' => [
        'discord' => env('BOOKSHELVES_NOTIFICATION_DISCORD', false),
    ],
];
