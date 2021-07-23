# **About**

This Wiki is about Bookshelves project, you will find two parts covered here: the back-end part made in Laravel
which is clearly the most important part in Bookshelves and the front-end part in NuxtJS which retrieves data from
the API in order to display it in a nice user interface.

If you are interested in Bookshelves, you can keep only the back-end part and create your own front-end with the
technology you want. All the logic of Bookshelves is in the backend and it is even possible to not use an external
frontend and use Bookshelves with the internal backend interface.

## *Links*

🚀 [**bookshelves.ink**](https://bookshelves.ink): demo of Bookshelves  

📚 [**bookshelves.ink/wiki**](https://bookshelves.ink/wiki): wiki for Bookshelves usage  
📚 [**bookshelves.ink/docs**](https://bookshelves.ink/docs): API documentation  
📚 [**bookshelves.ink/opds**](https://bookshelves.ink/opds): OPDS feed for applications which can read this feed  
📚 [**bookshelves.ink/catalog**](https://bookshelves.ink/catalog): Catalog, a basic interface for eReader browser to download eBook from eReader  
📚 [**bookshelves.ink/webreader**](https://bookshelves.ink/webreader): Webreader, to read any Bookshelves eBook into your browser  

📀 [**gitlab.com/ewilan-riviere/bookshelves-back**](https://gitlab.com/ewilan-riviere/bookshelves-back) : back-end of Bookshelves  
🎨 [**gitlab.com/ewilan-riviere/bookshelves-front**](https://gitlab.com/ewilan-riviere/bookshelves-front) : front-end of Bookshelves  

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

# **II. `.env`**

## *a. For local*

```yaml
APP_URL=http://localhost:8000

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

# **III. Generate eBooks data**

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

## *e. Mails*

TODO

## *g. MetadataExtractor*

TODO

## *i. Wikipedia*

TODO

- WikipediaProvider

# **IV. Packages**

## *a. Auth*

[**laravel/sanctum**](https://github.com/laravel/sanctum): Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform.

Routes can be protected like this

```php
Route::middleware(['auth:sanctum'])->group(function () {
  // routes
}
```

### Login 419 error: "CSRF token mismatch"

```bash
php artisan cache:clear ; php artisan route:clear ; php artisan config:clear ; php artisan view:clear ; php artisan optimize:clear
```

## *b. API documentation*

[**knuckleswtf/scribe**](https://github.com/knuckleswtf/scribe): Scribe helps you generate API documentation for humans from your Laravel/Lumen/Dingo codebase. See a live example at [demo.scribe.knuckles.wtf](https://demo.scribe.knuckles.wtf).

If you use `php artisan serve`, knuckleswtf/scribe is available on `/docs`, like [**localhost:8000/docs**](http://localhost:8000/docs). You can set parameters into each Controller, check [**scribe.knuckles.wtf/laravel**](https://scribe.knuckles.wtf/laravel/) to know more, like this

```php
<?php

/**
 * @group Author
 *
 * Endpoint to get Authors data.
 */
class AuthorController extends Controller
{
  /**
   * GET Author collection
   *
   * <small class="badge badge-blue">WITH PAGINATION</small>
   *
   * You can get all Authors with alphabetic order on lastname with pagination.
   *
   * @queryParam per-page int Entities per page, '32' by default. No-example
   * @queryParam page int The page number, '1' by default. No-example
   * @responseFile public/storage/responses/authors.index.get.json
   */
  public function index(Request $request)
  {
    // ...
  }
}
```

And generate documentation

```bash
php artisan scribe:generate
```

## *c. Code linter*

### IDE helper

[**barryvdh/laravel-ide-helper**](https://github.com/barryvdh/laravel-ide-helper): to generate magic methods for each model to help IDE completion

```bash
composer helper
```

### larastan

[**nunomaduro/larastan**](https://github.com/nunomaduro/larastan): Adds static analysis to Laravel improving developer productivity and code quality.

```bash
php artisan larastan
```

### PHP CS Fixer

[**friendsofphp/php-cs-fixer**](https://github.com/friendsofphp/php-cs-fixer): A tool to automatically fix PHP Coding Standards issues

```bash
composer helper
```

## *d. Database and models*

- [**fakerphp/faker**](https://github.com/fakerphp/faker): Faker is a PHP library that generates fake data for you

### Enum

[**spatie/laravel-enum**](https://github.com/spatie/laravel-enum): Laravel support for spatie/enum

### Media library

[**spatie/laravel-medialibrary**](https://github.com/spatie/laravel-medialibrary): Associate files with Eloquent models. If you update `registerMediaConversions()` in any Model, you can regenerate conversions

```bash
php artisan media-library:regenerate
```

### Tags

[**spatie/laravel-tags**](https://github.com/spatie/laravel-tags): Add tags and taggable behaviour to your Laravel app

## *e. Tools*

### Clockwork

[**itsgoingd/clockwork**](https://github.com/itsgoingd/clockwork): Clockwork is a development tool for PHP available right in your browser. Clockwork gives you an insight into your application runtime - including request data, performance metrics, log entries, database queries, cache queries, redis commands, dispatched events, queued jobs, rendered views and more - for HTTP requests, commands, queue jobs and tests.

To use Clockwork, you have to install browser extension: [**Chrome**](https://chrome.google.com/webstore/detail/clockwork/dmggabnehkmmfmdffgajcflpdjlnoemp) or [**Firefox**](https://addons.mozilla.org/en-US/firefox/addon/clockwork-dev-tools/). When it's done, just open DevTools and choose Clockwork.

### CORS

[**fruitcake/laravel-cors**](https://github.com/fruitcake/laravel-cors): Adds CORS (Cross-Origin Resource Sharing) headers support in your Laravel application

### Images

- [**spatie/image**](https://github.com/spatie/image): Manipulate images with an expressive API
- [**oscarotero/inline-svg**](https://github.com/oscarotero/inline-svg): Insert svg in the html so you can use css to change the style
- [**spatie/laravel-image-optimizer**](https://github.com/spatie/laravel-image-optimizer): Optimize images in your Laravel app

### Markdown

- [**thephpleague/commonmark**](https://github.com/thephpleague/commonmark): Highly-extensible PHP Markdown parser which fully supports the CommonMark and GFM specs.
- [**spatie/commonmark-highlighter**](https://github.com/spatie/commonmark-highlighter): Highlight code blocks with league/commonmark
- [**thephpleague/html-to-markdown**](https://github.com/thephpleague/html-to-markdown): Convert HTML to Markdown with PHP
- [**spatie/laravel-markdown**](https://github.com/spatie/laravel-markdown): A highly configurable markdown renderer and Blade component for Laravel

### XML

[**spatie/array-to-xml**](https://github.com/spatie/array-to-xml): A simple class to convert an array to xml

### Routing

[**spatie/laravel-route-attributes**](https://github.com/spatie/laravel-route-attributes): Use PHP 8 attributes to register routes in a Laravel app

### Telescope

*Only available on `routes/web.php`*

- [**laravel/telescope**](https://github.com/laravel/telescope): Telescope makes a wonderful companion to your local Laravel development environment. Telescope provides insight into the requests coming into your application, exceptions, log entries, database queries, queued jobs, mail, notifications, cache operations, scheduled tasks, variable dumps, and more.
- [**fruitcake/laravel-telescope-toolbar**](https://github.com/fruitcake/laravel-telescope-toolbar): A toolbar for Laravel Telescope, based on the Symfony Web Profiler.

To enable Telescope, just change variable in `.env`

```yaml
TELESCOPE_ENABLED=true
```

*Note: only useful in local*

You can use [**laravel/telescope**](https://github.com/laravel/telescope) on Bookshelves at [**http://localhost:8000/telescope**](http://localhost:8000/telescope) if you serve project with `php artisan serve` (adapt URL if you have VHost).

## *f. Tests*

- [**phpunit.de**](https://phpunit.de): `phpunit/phpunit` package doc
- [**pestphp.com**](https://pestphp.com): `pestphp/pest` package doc

```bash
php artisan migrate --database=testing
```

You can run Pest and PHP Unit tests

```bash
php artisan pest:run
```

# V. **Deployment**

## a. *VHost: NGINX*

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
