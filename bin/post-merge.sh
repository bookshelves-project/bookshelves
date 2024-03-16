#!/bin/bash

# supervisorctl stop bookshelves-worker
php artisan inertia:stop-ssr
composer i
php artisan migrate --force
pnpm i
pnpm build
php artisan optimize:fresh
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan inertia:start-ssr &
# supervisorctl start bookshelves-worker
