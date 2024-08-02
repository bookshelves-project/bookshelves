#!/bin/sh

echo "👋 Hello, world!"

cd /var/www/html
php artisan db:show
php artisan migrate --force
php artisan db:seed --class=EmptySeeder --force
