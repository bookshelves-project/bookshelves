#!/bin/bash

# php artisan inertia:stop-ssr
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
# php artisan inertia:start-ssr &
