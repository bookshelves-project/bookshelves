<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Steward publishable
    |--------------------------------------------------------------------------
    |
    | For `publish:scheduled` command, set here all models with `Publishable` trait.
    |
    */

    'publishable' => [
        // \App\Models\Example::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward scoutable
    |--------------------------------------------------------------------------
    |
    | For `scout:fresh` command, set here all models with `Searchable` trait.
    |
    */

    'scoutable' => [
        // \App\Models\Example::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward scoutable
    |--------------------------------------------------------------------------
    |
    | For `scout:fresh` command, set here all models with `Searchable` trait.
    |
    */

    'mediable' => [
        // \App\Models\Example::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward media
    |--------------------------------------------------------------------------
    |
    | Set extensions for `Mediable` trait and `media:clean` command.
    |
    */

    'media' => [
        'default' => false,
        'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'avif'],
    ],

    /*
    |--------------------------------------------------------------------------
    | knuckleswtf/scribe
    |--------------------------------------------------------------------------
    |
    | To custom `knuckleswtf/scribe` package.
    |
    */

    'scribe' => [
        'endpoints' => [
            // 'book' => [
            //     'class' => \App\Models\Book::class,
            //     'routes' => ['books.show', 'books.update', 'books.destroy'],
            //     'field' => 'slug',
            // ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward filament
    |--------------------------------------------------------------------------
    |
    | To custom `filament/filament` package.
    |
    */

    'filament' => [
        'logo' => [
            'default' => env('FILAMENT_LOGO_DEFAULT', 'images/logo.svg'),
            'dark' => env('FILAMENT_LOGO_DARK', 'images/logo-dark.svg'),
        ],
        'logo-inline' => [
            'default' => env('FILAMENT_LOGO_INLINE_DEFAULT', 'images/logo-inline.svg'),
            'dark' => env('FILAMENT_LOGO_INLINE_DARK', 'images/logo-inline-dark.svg'),
        ],
        'widgets' => [
            'welcome' => [
                'url' => 'https://filamentphp.com/docs',
                'label' => 'filament::widgets/filament-info-widget.buttons.visit_documentation.label',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward query
    |--------------------------------------------------------------------------
    |
    | To manage `HttpQuery` and `Queryable` trait.
    |
    */

    'query' => [
        'default_sort' => 'id',
        'default_sort_direction' => 'asc',
        'limit' => 15,
        'full' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward HTTP
    |--------------------------------------------------------------------------
    |
    | To manage `HttpService`.
    |
    */

    'http' => [
        'pool_limit' => env('STEWARD_HTTP_POOL_LIMIT', 250),
        'async_allow' => env('STEWARD_HTTP_ASYNC_ALLOW', true),
    ],
];
