#!/bin/bash

# php8.2 artisan inertia:stop-ssr
# supervisorctl stop bookshelves-worker
composer i
php artisan migrate --force
pnpm i
pnpm build
pnpm build:ssr
php artisan optimize:fresh
php artisan config:cache
php artisan route:cache
php artisan view:cache
# supervisorctl start bookshelves-worker
# nohup php8.2 artisan inertia:start-ssr &

# to kill nohup
# ps aux | grep ssr
# kill <pid>
# or
# php8.2 artisan inertia:stop-ssr
