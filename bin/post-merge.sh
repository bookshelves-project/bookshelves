#!/bin/bash

# php8.2 artisan inertia:stop-ssr
# pm2 stop bookshelves-ssr
# supervisorctl stop bookshelves-worker
composer i
php artisan migrate --force
php artisan typescriptable
pnpm i
pnpm build
pnpm build:ssr
php artisan optimize:fresh
php artisan config:cache
php artisan route:cache
php artisan view:cache
# supervisorctl start bookshelves-worker
# pm2 start bookshelves-ssr
# nohup php8.2 artisan inertia:start-ssr &

# to kill nohup
# ps aux | grep ssr
# kill <pid>
# or
# php8.2 artisan inertia:stop-ssr
