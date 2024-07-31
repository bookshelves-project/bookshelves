ARG NODE_VERSION=20.16.0
ARG PHP_VERSION=8.2

FROM node:${NODE_VERSION}-alpine AS node_server

FROM serversideup/php:${PHP_VERSION}-fpm-nginx-alpine AS php_server

COPY --chmod=755 ./docker/99-init.sh /etc/entrypoint.d/
COPY ./docker/php/custom-php.ini /usr/local/etc/php/conf.d/

COPY --from=node_server /usr/lib /usr/lib
COPY --from=node_server /usr/local/lib /usr/local/lib
COPY --from=node_server /usr/local/include /usr/local/include
COPY --from=node_server /usr/local/bin /usr/local/bin

USER root

# requirements
# - autoconf (for imagick)
# - build-base (for imagick) / build-essential with apt
# - git (for imagick)
# - icu-dev (for intl)
# - imagemagick (for imagick)
# - imagemagick-dev (for imagick) / libmagickwand-dev with apt
# - zlib-dev (for imagick)
RUN apk add --no-cache \
  autoconf \
  build-base \
  git \
  icu-dev \
  imagemagick \
  imagemagick-dev \
  zlib-dev


# requirements for gd
RUN apk add --no-cache \
  libpng-dev

# extensions loaded: bcmath, exif, gd, intl
# extensions available: fileinfo, mbstring, pcntl, pdo_mysql, zip
RUN docker-php-ext-install \
  bcmath \
  exif \
  gd \
  intl \
  pdo_mysql

# extension installed: imagick
RUN git clone https://github.com/Imagick/imagick && \
  cd imagick && \
  phpize && \
  ./configure && \
  make && \
  make install

RUN npm install -g pnpm --force

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-scripts

RUN php artisan key:generate

RUN rm -rf public/storage && \
  php artisan storage:link

RUN rm -rf public/storage/covers

RUN php artisan config:cache && \
  php artisan route:cache && \
  php artisan view:cache && \
  php artisan optimize

RUN pnpm install
RUN pnpm build:no-check
# RUN pnpm build:ssr

# set permissions
# RUN chown -R www-data:www-data * && \
#   chown -R www-data:www-data .* && \
#   chown -R www-data:www-data storage bootstrap/cache && \
#   chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache && \
  chmod -R 775 storage bootstrap/cache

USER www-data

# CMD ["php artisan migrate --force"]
