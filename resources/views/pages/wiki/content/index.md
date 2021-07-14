# About

This Wiki is about Bookshelves project, you will find two parts covered here: the back-end part made in Laravel
which is clearly the most important part in Bookshelves and the front-end part in NuxtJS which retrieves data from
the API in order to display it in a nice user interface.

If you are interested in Bookshelves, you can keep only the back-end part and create your own front-end with the
technology you want. All the logic of Bookshelves is in the backend and it is even possible to not use an external
frontend and use Bookshelves with the internal backend interface.

# Demo & documentation

🚀 [**bookshelves.ink**](https://bookshelves.ink): demo of Bookshelves  
📚 [**bookshelves.ink/wiki**](https://bookshelves.ink/wiki): wiki for Bookshelves usage  
📚 [**bookshelves.ink/docs**](https://bookshelves.ink/docs): API documentation  

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

## *a. Swagger*

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

- <https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch=pierre%20bottero&format=json>
- <http://fr.wikipedia.org/w/api.php?action=query&prop=info&pageids=1064109&inprop=url&format=json&prop=info|extracts&inprop=url>
- <https://en.wikipedia.org/w/api.php?format=json&action=query&origin=*&titles=Pierre%20Bottero&prop=info|extracts&inprop=url>

# **IV. `.env`**

## *a. For local*

```yml
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

```yml
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=<mailtrap_username>
MAIL_PASSWORD=<mailtrap_password>
MAIL_FROM_ADDRESS=noreply@bookshelves.ink
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=contact@bookshelves.ink
MAIL_TO_NAME="${APP_NAME}"
```

## *b. For production*

```yml
APP_URL=https://www.mydomain.com

L5_SWAGGER_GENERATE_ALWAYS=false
L5_SWAGGER_BASE_PATH=/api

SANCTUM_STATEFUL_DOMAINS=www.mydomain.com
SESSION_DOMAIN=.mydomain.com

TELESCOPE_ENABLED=false
```

Setup for [**Mailgun**](https://www.mailgun.com/)

> For credentials
>
> - Create an account
> - After setup domain
> - Sending -> Domain settings -> SMTP credentials

```yml
MAIL_HOST=smtp.eu.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=<mailgun_user_login>
MAIL_PASSWORD=<mailgun_user_password>
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
