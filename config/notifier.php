<?php

return [
    // Default notifier client to send HTTP request, can be `stream`, `curl` or `guzzle`.
    // `guzzle` is not included in this package, you need to install it manually.
    'client' => env('NOTIFIER_CLIENT', 'stream'),

    'discord' => [
        // Default Discord webhook URL.
        'webhook' => env('NOTIFIER_DISCORD_WEBHOOK', null),
        // Default Discord username.
        'username' => env('NOTIFIER_DISCORD_USERNAME', 'Bookshelves'),
        // Default Discord avatar URL.
        'avatar_url' => env('NOTIFIER_DISCORD_AVATAR_URL', null),
    ],

    'mail' => [
        // Use Laravel mailer instead package from `.env` file.
        'laravel_override' => env('NOTIFIER_MAIL_LARAVEL_OVERRIDE', false),
        // Set default subject for mail.
        'subject' => env('NOTIFIER_MAIL_SUBJECT', 'Bookshelves'),
        // Set default mailer from `.env` file.
        'mailer' => env('NOTIFIER_MAIL_MAILER', 'smtp'),
        'host' => env('NOTIFIER_MAIL_HOST', 'mailpit'),
        'port' => env('NOTIFIER_MAIL_PORT', 1025),
        'username' => env('NOTIFIER_MAIL_USERNAME', null),
        'password' => env('NOTIFIER_MAIL_PASSWORD', null),
        'encryption' => env('NOTIFIER_MAIL_ENCRYPTION', 'tls'),
        'from_address' => env('NOTIFIER_MAIL_FROM_ADDRESS', null),
        'from_name' => env('NOTIFIER_MAIL_FROM_NAME', null),
        'to_address' => env('NOTIFIER_MAIL_TO_ADDRESS', null),
        'to_name' => env('NOTIFIER_MAIL_TO_NAME', null),
    ],

    'slack' => [
        // Default Slack webhook URL.
        'webhook' => env('NOTIFIER_SLACK_WEBHOOK', null),
    ],

    'http' => [
        // Default HTTP URL to send request.
        'url' => env('NOTIFIER_HTTP_URL', null),
    ],

    // This feature use `filament/notifications` package, not included in this package.
    'to_database' => [
        // Default user model for notification.
        'model' => env('NOTIFIER_TO_DATABASE_MODEL', 'App\Models\User'),
        // Recipients ID for notification.
        'recipients_id' => explode(',', env('NOTIFIER_TO_DATABASE_RECIPIENTS_ID', ''), 0),
    ],

    'journal' => [
        // Write logs for debugging when notifications are sent.
        'debug' => env('NOTIFIER_JOURNAL_DEBUG', false),
        // Write error logs with `error_log` function, in addition to Laravel log.
        'use_error_log' => env('NOTIFIER_JOURNAL_USE_ERROR_LOG', true),
    ],
];
