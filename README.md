# Bookshelves · Back <!-- omit in toc -->

[![php](https://img.shields.io/badge/dynamic/json?label=PHP&query=require.php&url=https%3A%2F%2Fgitlab.com%2FEwieFairy%2Fbookshelves-back%2F-%2Fraw%2Fmaster%2Fcomposer.json&logo=php&logoColor=ffffff&color=777bb4&style=flat-square)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)

[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v8.0&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)
[![swagger](https://img.shields.io/static/v1?label=Swagger&message=v3.0&color=85EA2D&style=flat-square&logo=swagger&logoColo=ffffff)](https://swagger.io)

[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.15&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)
[![yarn](https://img.shields.io/static/v1?label=Yarn&message=v1.2&color=2C8EBB&style=flat-square&logo=yarn&logoColor=ffffff)](https://yarnpkg.com/lang/en/)

- 📀 [**bookshelves-back**](https://gitlab.com/EwieFairy/bookshelves-back) : back-end of Bookshelves (current repository)
- 🎨 [**bookshelves-front**](https://gitlab.com/EwieFairy/bookshelves-front) : front-end of Bookshelves
- 💻 [**bookshelves.git-projects.xyz**](https://bookshelves.git-projects.xyz) : preprod
- 📚 [**Documentation**](https://bookshelves.git-projects.xyz/api/documentation)

**Table of contents**

- [**TODO**](#todo)
- [**I. Setup**](#i-setup)
- [**II. Generate eBooks data**](#ii-generate-ebooks-data)
  - [*a. Add your own eBooks*](#a-add-your-own-ebooks)
  - [*b. Test with demo eBook*](#b-test-with-demo-ebook)
- [**III. Tools**](#iii-tools)
  - [*a. Swagger*](#a-swagger)
  - [*b. Laravel Telescope*](#b-laravel-telescope)
  - [*c. Spatie Media*](#c-spatie-media)
  - [*d. Tests*](#d-tests)
  - [*e. Mails*](#e-mails)
  - [*f. Sanctum*](#f-sanctum)
    - [Login 419 error: "CSRF token mismatch"](#login-419-error-csrf-token-mismatch)
  - [*g. EpubParser*](#g-epubparser)
  - [*h. Recaptcha*](#h-recaptcha)
  - [*i. Larastan*](#i-larastan)
- [**IIII. `dotenv`**](#iiii-dotenv)
  - [*a. For local*](#a-for-local)
  - [*b. For production*](#b-for-production)

---

## **TODO**

- Fix Resources collection with ResourceCollection extends
- Logs for EpubParser
- Improve libre ebooks meta
- Add attribute on each method for Controller
- Check attributes
  - <https://www.amitmerchant.com/how-to-use-php-80-attributes>
  - <https://stitcher.io/blog/attributes-in-php-8>
  - <https://grafikart.fr/tutoriels/attribut-php8-1371>
- mailing: <https://www.mailgun.com>
- numberOfPages: <https://idpf.github.io/epub-guides/package-metadata/#schema-numberOfPages>
  - async epubparser for Google data
- Add explanation form each part of EpubParser
- spatie/laravel-medialibrary
  - <https://spatie.be/docs/laravel-medialibrary/v9/converting-images/optimizing-converted-images>
  - <https://spatie.be/docs/laravel-medialibrary/v9/handling-uploads-with-media-library-pro/handling-uploads-with-vue>
  - conversions name
    - <https://spatie.be/docs/laravel-medialibrary/v9/advanced-usage/naming-generated-files>
    - <https://spatie.be/docs/laravel-medialibrary/v9/converting-images/defining-conversions>
- larastan upgrade level

```bash
scoop reset php/php7.4-nts

sudo update-alternatives --config php
sudo update-alternatives --set phar /usr/bin/phar7.4

sudo service nginx restart
sudo service php7.1-fpm or php7.2-fpm  restart

composer require friendsofphp/php-cs-fixer --dev
composer global require friendsofphp/php-cs-fixer
```

---

## **I. Setup**

Prerequisites for XML parse, spatie image optimize tools, here for `php8.0`

```bash
sudo apt-get install -y php8.0-xml php8.0-gd ; sudo apt-get install -y jpegoptim optipng pngquant gifsicle webp ; npm install -g svgo
```

Download dependencies

```bash
composer install
```

Execute `setup` and follow guide

```bash
php artisan setup
```

---

## **II. Generate eBooks data**

### *a. Add your own eBooks*

Add EPUB files in `public/storage/books-raw` and execute Epub Parser

> `php artisan books:generate -h` to check options

```bash
# for fresh installation (erase current database) with force option for production
php artisan books:generate -fF
```

### *b. Test with demo eBook*

If you want to test Bookshelves, you can use `books:test` to generate data from libre eBooks

> `php artisan books:test -h` to check options

```bash
php artisan books:test
```

---

## **III. Tools**

### *a. Swagger*

- [**zircote.github.io/swagger-php**](https://zircote.github.io/swagger-php/): documentation of Swagger PHP
- [**github.com/DarkaOnLine/L5-Swagger**](https://github.com/DarkaOnLine/L5-Swagger): `darkaonline/l5-swagger` repository
- [**ivankolodiy.medium.com**](https://ivankolodiy.medium.com/how-to-write-swagger-documentation-for-laravel-api-tips-examples-5510fb392a94): useful article about L5-Swagger
- [**localhost:8000/api/documentation**](http://localhost:8000/api/documentation): if you use `php artisan serve`, Swagger is available on `/api/documentation`

To generate documentation from **@OA** comments

```yml
# In dotenv
L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_BASE_PATH=/api
```

```bash
php artisan l5-swagger:generate
```

To update documentation change **@OA** comments in controllers

```php
<?php

// ...

class BookController extends Controller
{
  /**
  * @OA\Get(
  *     path="/books",
  *     tags={"books"},
  *     summary="List of books",
  *     description="Books",
  *     @OA\Response(
  *         response=200,
  *         description="Successful operation"
  *     )
  * )
  */
  public function index()
  {
    // ...
  }
}

```

### *b. Laravel Telescope*

- [**laravel.com/docs/8.x/telescope**](https://laravel.com/docs/8.x/telescope): `laravel/telescope` package doc

*Note: only useful in local*

You can use [**laravel/telescope**](https://github.com/laravel/telescope) on Bookshelves at [**http://localhost:8000/telescope**](http://localhost:8000/telescope) if you serve project with `php artisan serve` (adapt URL if you have VHost).

In **dotenv** set `TELESCOPE_ENABLED` to `true`

```yml
TELESCOPE_ENABLED=true
```

### *c. Spatie Media*

- [**spatie.be/docs/laravel-medialibrary**](https://spatie.be/docs/laravel-medialibrary/v9/introduction): `spatie/laravel-medialibrary` package doc

If you update `registerMediaConversions()` in any Model, you can regenerate conversions

```bash
php artisan media-library:regenerate
```

### *d. Tests*

- [**phpunit.de**](https://phpunit.de): `phpunit/phpunit` package doc
- [**pestphp.com**](https://pestphp.com): `pestphp/pest` package doc

You can run Pest and PHP Unit tests

```bash
php artisan pest:run
```

### *e. Mails*

TODO

### *f. Sanctum*

- [**laravel.com/docs/8.x/sanctum**](https://laravel.com/docs/8.x/sanctum): `laravel/sanctum` package doc

TODO

#### Login 419 error: "CSRF token mismatch"

```bash
php artisan cache:clear ; php artisan route:clear ; php artisan config:clear ; php artisan view:clear ; php artisan optimize:clear
```

### *g. EpubParser*

TODO

### *h. Recaptcha*

- [**laravel-recaptcha-docs.biscolab.com/docs**](https://laravel-recaptcha-docs.biscolab.com/docs/intro): `biscolab/laravel-recaptcha` package doc

TODO

### *i. Larastan*

- [**github.com/nunomaduro/larastan**](https://github.com/nunomaduro/larastan): package

```bash
php artisan larastan
```

---

## **IIII. `dotenv`**

### *a. For local*

```yml
APP_URL=http://api.bookshelves.test
# OR
# APP_URL=http://localhost:8000

MAIL_USERNAME=<mailtrap>
MAIL_PASSWORD=<mailtrap>

L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_BASE_PATH=/api

SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost

TELESCOPE_ENABLED=true

RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
```

### *b. For production*

```yml
APP_URL=https://www.mydomain.com

# ...

MAIL_USERNAME=<mail>
MAIL_PASSWORD=<mail>

L5_SWAGGER_GENERATE_ALWAYS=false
L5_SWAGGER_BASE_PATH=/api

SANCTUM_STATEFUL_DOMAINS=www.mydomain.com
SESSION_DOMAIN=.mydomain.com

TELESCOPE_ENABLED=false

RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
```

```nginx
server {
  server_name www.bookshelves.ink;

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

  server_name www.bookshelves.ink;

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
