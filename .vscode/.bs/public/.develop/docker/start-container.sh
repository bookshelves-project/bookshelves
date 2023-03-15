#!/bin/sh
set -e

php-fpm -D
nginx -g 'pid /tmp/nginx.pid; daemon off;'
