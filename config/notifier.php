<?php

return [
    'discord' => [
        // Default Discord webhook URL.
        'webhook' => env('NOTIFIER_DISCORD_WEBHOOK', null),
        // Default Discord username.
        'username' => env('NOTIFIER_DISCORD_USERNAME', null),
        // Default Discord avatar URL.
        'avatar_url' => env('NOTIFIER_DISCORD_AVATAR_URL', null),
    ],

    'mail' => [
        // Use Laravel mailer instead package from `.env` file.
        'laravel_override' => env('NOTIFIER_MAIL_LARAVEL_OVERRIDE', false),
        // Set default subject for mail.
        'subject' => env('NOTIFIER_MAIL_SUBJECT', 'Notifier'),
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

    // This feature use `filament/notifications` package, not included in this package.
    'to_database' => [
        // Default user model for notification.
        'model' => env('NOTIFIER_TO_DATABASE_MODEL', 'App\Models\User'),
        // Recipients ID for notification.
        'recipients_id' => explode(',', env('NOTIFIER_TO_DATABASE_RECIPIENTS_ID', ''), 0),
    ],
];
