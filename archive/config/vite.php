<?php

return [
    'dev_server' => env('VITE_DEV_SERVER', 'local' === env('APP_ENV')),
    'dev_server_host' => env('VITE_DEV_SERVER_HOST', '127.0.0.1'),
];
