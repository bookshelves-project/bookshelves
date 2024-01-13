#!/bin/bash

supervisorctl stop kiwiflix-worker
composer i
php artisan migrate --force
pnpm i
pnpm build
php artisan optimize:fresh
php artisan config:cache
php artisan route:cache
php artisan view:cache
supervisorctl start kiwiflix-worker
