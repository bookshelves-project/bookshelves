FROM registry.okami101.io/adr1enbe4udou1n/laravel-rad-stack

COPY app app/
COPY bootstrap bootstrap/
COPY config config/
COPY database database/
COPY public public/
COPY resources resources/
COPY storage storage/
COPY vendor vendor/
COPY artisan composer.json composer.lock ./

RUN php artisan storage:link
RUN php artisan elfinder:publish
RUN chown -R www-data:www-data bootstrap/cache storage

EXPOSE 80

ENTRYPOINT ["start-container"]
