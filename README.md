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
  - [*II. a. Add your own eBooks*](#ii-a-add-your-own-ebooks)
  - [*II. b. Test with demo eBook*](#ii-b-test-with-demo-ebook)
- [**III. Tools**](#iii-tools)
  - [*III. a. Swagger*](#iii-a-swagger)
  - [*III. b. Laravel Telescope*](#iii-b-laravel-telescope)
  - [*III. c. Spatie Media*](#iii-c-spatie-media)
  - [*III. d. Tests*](#iii-d-tests)
  - [*III. e. Mails*](#iii-e-mails)
  - [*III. f. Sanctum*](#iii-f-sanctum)
    - [Login 419 error: "CSRF token mismatch"](#login-419-error-csrf-token-mismatch)
  - [*III. g. EpubParser*](#iii-g-epubparser)
  - [*III. h. Recaptcha*](#iii-h-recaptcha)
  - [*III. i. Larastan*](#iii-i-larastan)
- [**IIII. `dotenv`**](#iiii-dotenv)
  - [*IIII. a. For local*](#iiii-a-for-local)
  - [*IIII. b. For production*](#iiii-b-for-production)

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

### *II. a. Add your own eBooks*

Add EPUB files in `public/storage/books-raw` and execute Epub Parser

> `php artisan books:generate -h` to check options

```bash
# for fresh installation (erase current database) with force option for production
php artisan books:generate -fF
```

### *II. b. Test with demo eBook*

If you want to test Bookshelves, you can use `books:test` to generate data from libre eBooks

> `php artisan books:test -h` to check options

```bash
php artisan books:test
```

---

## **III. Tools**

### *III. a. Swagger*

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

### *III. b. Laravel Telescope*

- [**laravel.com/docs/8.x/telescope**](https://laravel.com/docs/8.x/telescope): `laravel/telescope` package doc

*Note: only useful in local*

You can use [**laravel/telescope**](https://github.com/laravel/telescope) on Bookshelves at [**http://localhost:8000/telescope**](http://localhost:8000/telescope) if you serve project with `php artisan serve` (adapt URL if you have VHost).

In **dotenv** set `TELESCOPE_ENABLED` to `true`

```yml
TELESCOPE_ENABLED=true
```

### *III. c. Spatie Media*

- [**spatie.be/docs/laravel-medialibrary**](https://spatie.be/docs/laravel-medialibrary/v9/introduction): `spatie/laravel-medialibrary` package doc

If you update `registerMediaConversions()` in any Model, you can regenerate conversions

```bash
php artisan media-library:regenerate
```

### *III. d. Tests*

- [**phpunit.de**](https://phpunit.de): `phpunit/phpunit` package doc
- [**pestphp.com**](https://pestphp.com): `pestphp/pest` package doc

You can run Pest and PHP Unit tests

```bash
php artisan pest:run
```

### *III. e. Mails*

TODO

### *III. f. Sanctum*

- [**laravel.com/docs/8.x/sanctum**](https://laravel.com/docs/8.x/sanctum): `laravel/sanctum` package doc

TODO

#### Login 419 error: "CSRF token mismatch"

```bash
php artisan cache:clear ; php artisan route:clear ; php artisan config:clear ; php artisan view:clear ; php artisan optimize:clear
```

### *III. g. EpubParser*

TODO

### *III. h. Recaptcha*

- [**laravel-recaptcha-docs.biscolab.com/docs**](https://laravel-recaptcha-docs.biscolab.com/docs/intro): `biscolab/laravel-recaptcha` package doc

TODO

### *III. i. Larastan*

- [**github.com/nunomaduro/larastan**](https://github.com/nunomaduro/larastan): package

```bash
php artisan larastan
```

---

## **IIII. `dotenv`**

### *IIII. a. For local*

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

### *IIII. b. For production*

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
