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

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'cms' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/cms'),
            'url' => env('APP_URL').'/storage/media/cms',
            'visibility' => 'public',
        ],

        'cover' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/covers'),
            'url' => env('APP_URL').'/storage/media/covers',
            'visibility' => 'public',
        ],

        'format' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/formats'),
            'url' => env('APP_URL').'/storage/media/formats',
            'visibility' => 'public',
        ],

        'media' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/media'),
            'url' => env('APP_URL').'/storage/media/media',
            'visibility' => 'public',
        ],

        'post' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/posts'),
            'url' => env('APP_URL').'/storage/media/posts',
            'visibility' => 'public',
        ],

        'user' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/users'),
            'url' => env('APP_URL').'/storage/media/users',
            'visibility' => 'public',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'media' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media'),
            'url' => '/storage/media',
        ],

        'files' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files'),
            'url' => env('APP_URL').'/storage/files',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
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
