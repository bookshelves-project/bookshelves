<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
        ],

        'authors' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/media/authors'),
            'url'        => env('APP_URL').'/storage/media/authors',
            'visibility' => 'public',
        ],

        'books' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/media/books'),
            'url'        => env('APP_URL').'/storage/media/books',
            'visibility' => 'public',
        ],

        'books_epubs' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/media/books_epubs'),
            'url'        => env('APP_URL').'/storage/media/books_epubs',
            'visibility' => 'public',
        ],

        'series' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/media/series'),
            'url'        => env('APP_URL').'/storage/media/series',
            'visibility' => 'public',
        ],

        'google' => [
            'driver'       => 'google',
            'clientId'     => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'folderId'     => env('GOOGLE_DRIVE_FOLDER_ID'),
            // 'teamDriveId' => env('GOOGLE_DRIVE_TEAM_DRIVE_ID'),
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver'   => 's3',
            'key'      => env('AWS_ACCESS_KEY_ID'),
            'secret'   => env('AWS_SECRET_ACCESS_KEY'),
            'region'   => env('AWS_DEFAULT_REGION'),
            'bucket'   => env('AWS_BUCKET'),
            'url'      => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
