# About

This Wiki is about Bookshelves project, you will find two parts covered here: the back-end part made in Laravel
which is clearly the most important part in Bookshelves and the front-end part in NuxtJS which retrieves data from
the API in order to display it in a nice user interface.

If you are interested in Bookshelves, you can keep only the back-end part and create your own front-end with the
technology you want. All the logic of Bookshelves is in the backend and it is even possible to not use an external
frontend and use Bookshelves with the internal backend interface.

# Links

🚀 [**bookshelves.ink**](https://bookshelves.ink): demo of Bookshelves  

📚 [**bookshelves.ink/wiki**](https://bookshelves.ink/wiki): wiki for Bookshelves usage  
📚 [**bookshelves.ink/docs**](https://bookshelves.ink/docs): API documentation  
📚 [**bookshelves.ink/opds**](https://bookshelves.ink/opds): OPDS  
📚 [**bookshelves.ink/catalog**](https://bookshelves.ink/catalog): Catalog  

📀 [**gitlab.com/ewilan-riviere/bookshelves-back**](https://gitlab.com/ewilan-riviere/bookshelves-back) : back-end of Bookshelves  
🎨 [**gitlab.com/ewilan-riviere/bookshelves-front**](https://gitlab.com/ewilan-riviere/bookshelves-front) : front-end of Bookshelves  

# TODO

```bash
"php"
"friendsofphp/php-cs-fixer"
"fruitcake/laravel-cors"
"itsgoingd/clockwork"
"laravel/sanctum"
"laravel/telescope"
"league/commonmark"
"league/html-to-markdown"
"oscarotero/inline-svg"
"spatie/array-to-xml"
"spatie/commonmark-highlighter"
"spatie/image"
"spatie/laravel-enum"
"spatie/laravel-image-optimizer"
"spatie/laravel-markdown"
"spatie/laravel-medialibrary"
"spatie/laravel-route-attributes"
"spatie/laravel-tags"
"barryvdh/laravel-ide-helper"
"fakerphp/faker"
"fruitcake/laravel-telescope-toolbar"
"knuckleswtf/scribe"
```

# **I. Setup**

## *a. Dependencies*

Extensions for PHP, here for `php8.0`

```bash
sudo apt-get install -y php8.0-xml php8.0-gd
```

For spatie image optimize tools

```bash
sudo apt-get install -y jpegoptim optipng pngquant gifsicle webp
```

```bash
npm install -g svgo
```

## *b. Setup*

Download dependencies

```bash
composer install
```

Execute `setup` and follow guide

```bash
php artisan setup
```

# **II. Generate eBooks data**

## *a. Add your own eBooks*

Add EPUB files in `public/storage/raw/books` and execute Epub Parser

> `php artisan bookshelves:generate -h` to check options

```bash
# for fresh installation (erase current database) with force option for production
php artisan bookshelves:generate -fF
```

## *b. Test with demo eBook*

If you want to test Bookshelves, you can use `bookshelves:sample` to generate data from libre eBooks

> `php artisan bookshelves:sample -h` to check options

```bash
php artisan bookshelves:sample
```

# **III. Tools**

## *a. API documentation: knuckleswtf/scribe*

- [**scribe.knuckles.wtf/laravel**](https://scribe.knuckles.wtf/laravel/): documentation of knuckleswtf/scribe
- [**github.com/knuckleswtf/scribe**](https://github.com/knuckleswtf/scribe): `knuckleswtf/scribe` repository
- [**localhost:8000/docs**](http://localhost:8000/docs): if you use `php artisan serve`, knuckleswtf/scribe is available on `/docs`

To generate documentation from controllers

```bash
php artisan scribe:generate
```

To update documentation change comments in controllers

```php
<?php

// ...

class BookController extends Controller
{
  /**
    * GET Book collection
    *
    * <small class="badge badge-blue">WITH PAGINATION</small>
    *
    * Get all Books ordered by 'title' & Series' 'title'.
    *
    * @queryParam per-page int Entities per page, '32' by default. No-example
    * @queryParam page int The page number, '1' by default. No-example
    * @queryParam all bool To disable pagination, false by default. No-example
    * @queryParam lang filters[fr,en] To select specific lang, null by default. No-example
    *
    * @responseField title string Book's title.
    *
    * @responseFile public/storage/responses/books.index.get.json
    */
  public function index()
  {
    // ...
  }
}

```

## *b. Laravel Telescope*

- [**laravel.com/docs/8.x/telescope**](https://laravel.com/docs/8.x/telescope): `laravel/telescope` package doc

*Note: only useful in local*

You can use [**laravel/telescope**](https://github.com/laravel/telescope) on Bookshelves at [**http://localhost:8000/telescope**](http://localhost:8000/telescope) if you serve project with `php artisan serve` (adapt URL if you have VHost).

In **dotenv** set `TELESCOPE_ENABLED` to `true`

```yml
TELESCOPE_ENABLED=true
```

## *c. Spatie Media*

- [**spatie.be/docs/laravel-medialibrary**](https://spatie.be/docs/laravel-medialibrary/v9/introduction): `spatie/laravel-medialibrary` package doc

If you update `registerMediaConversions()` in any Model, you can regenerate conversions

```bash
php artisan media-library:regenerate
```

## *d. Tests*

- [**phpunit.de**](https://phpunit.de): `phpunit/phpunit` package doc
- [**pestphp.com**](https://pestphp.com): `pestphp/pest` package doc

```bash
php artisan migrate --database=testing
```

You can run Pest and PHP Unit tests

```bash
php artisan pest:run
```

## *e. Mails*

TODO

## *f. Sanctum*

- [**laravel.com/docs/8.x/sanctum**](https://laravel.com/docs/8.x/sanctum): `laravel/sanctum` package doc

TODO

### Login 419 error: "CSRF token mismatch"

```bash
php artisan cache:clear ; php artisan route:clear ; php artisan config:clear ; php artisan view:clear ; php artisan optimize:clear
```

## *g. MetadataExtractor*

TODO

## *h. Larastan*

- [**github.com/nunomaduro/larastan**](https://github.com/nunomaduro/larastan): package

```bash
php artisan larastan
```

## *i. Wikipedia*

TODO

- WikipediaProvider

# **IV. `.env`**

## *a. For local*

```yaml
APP_URL=http://localhost:8000
# OR
# APP_URL=http://api.bookshelves.test

L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_BASE_PATH=/api

SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost

TELESCOPE_ENABLED=true

BOOKSHELVES_ADMIN_EMAIL=admin@mail.com
BOOKSHELVES_ADMIN_PASSWORD=password
```

Setup for [**Mailtrap**](https://mailtrap.io/)

```yaml
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=mailtrap_username
MAIL_PASSWORD=mailtrap_password
MAIL_FROM_ADDRESS=noreply@bookshelves.ink
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=contact@bookshelves.ink
MAIL_TO_NAME="${APP_NAME}"
```

## *b. For production*

```yaml
APP_URL=https://www.mydomain.com

L5_SWAGGER_GENERATE_ALWAYS=false
L5_SWAGGER_BASE_PATH=/api

SANCTUM_STATEFUL_DOMAINS=www.mydomain.com
SESSION_DOMAIN=.mydomain.com

TELESCOPE_ENABLED=false
```

Setup for [**Mailgun**](https://www.mailgun.com/)

For credentials

- Create an account
- After setup domain
- Sending -> Domain settings -> SMTP credentials

```yaml
MAIL_HOST=smtp.eu.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=mailgun_user_login
MAIL_PASSWORD=mailgun_user_password
MAIL_FROM_ADDRESS=noreply@bookshelves.ink
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=contact@bookshelves.ink
MAIL_TO_NAME="${APP_NAME}"
```

# V. **VHost**

## a. *NGINX*

```nginx
server {
  server_name bookshelves.ink;

  error_page 500 502 503 504 /index.html;
  location = /index.html {
    root /usr/share/nginx/html;
    internal;
  }

  location / {
    include proxy_params;
    proxy_pass http://localhost:3004;
  }

  location ~ ^/(admin|api|css|media|uploads|storage|docs|packages|cache|sanctum|login|logout) {
    include proxy_params;
    proxy_pass http://127.0.0.1:8000;
    proxy_buffer_size 128k;
    proxy_buffers 4 256k;
    proxy_busy_buffers_size 256k;
  }
}
server {
  listen 8000;
  listen [::]:8000;

  server_name bookshelves.ink;

  error_log /var/log/nginx/bookshelves.log warn;
  access_log /var/log/nginx/bookshelves.log;

  root /home/ewilan/www/bookshelves-back/public;
  index index.php;

  add_header X-Frame-Options "SAMEORIGIN";
  add_header X-XSS-Protection "1; mode=block";
  add_header X-Content-Type-Options "nosniff";

  charset utf-8;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  error_page 404 /index.php;

  location ~ ^/cache/resolve {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ ^/docs/ {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~* \.(js|css|png|jpg|jpeg|gif|ico|eot|svg|ttf|woff|woff2)$ {
    expires max;
    log_not_found off;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.0-fpm.sock;
    fastcgi_buffer_size 128k;
    fastcgi_buffers 4 256k;
    fastcgi_busy_buffers_size 256k;
  }

  location ~ /\.(?!well-known).* {
    deny all;
  }
}
```
