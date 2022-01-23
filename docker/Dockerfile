FROM php:8.0-fpm-alpine3.12

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions @composer opcache pdo_mysql exif gd imagick redis zip pcov

RUN apk add --no-cache nginx

RUN wget -O /usr/local/bin/local-php-security-checker "https://github.com/fabpot/local-php-security-checker/releases/download/v1.0.0/local-php-security-checker_1.0.0_linux_amd64"
RUN chmod +x /usr/local/bin/local-php-security-checker

COPY php.ini /usr/local/etc/php/php.ini
COPY nginx.conf /etc/nginx/conf.d/default.conf

COPY start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80

ENTRYPOINT ["start-container"]
