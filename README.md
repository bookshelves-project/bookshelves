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
- [**II. Tools**](#ii-tools)
  - [*II. a. Swagger*](#ii-a-swagger)
  - [*II. b. Laravel Telescope (only useful in local)*](#ii-b-laravel-telescope-only-useful-in-local)
  - [*II. c. Spatie Media*](#ii-c-spatie-media)
  - [*II. d. Tests*](#ii-d-tests)
- [**III. `dotenv`**](#iii-dotenv)

---

## **TODO**

- Multiple authors for Serie
- Fix Resources collection with ResourceCollection extends
- Logs for EpubParser
- Command to get basic books-raw/ with libre ebooks
- Null safe operator on all Resources & Collections / cleaning resources
- Add attribute on each method for Controller
- Check attributes
  - <https://www.amitmerchant.com/how-to-use-php-80-attributes>
  - <https://stitcher.io/blog/attributes-in-php-8>
  - <https://grafikart.fr/tutoriels/attribut-php8-1371>
- mailing: <https://www.mailgun.com>

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

Deownload dependencies

```bash
composer install
```

Execute `setup` and follow guide

```bash
php artisan setup ; mkdir public/storage/books-raw
```

Add EPUB files in `public/storage/books-raw` and execute Epub Parser

> `php artisan books:generate -h` to check options

```bash
# for fresh installation (erase current database)
php artisan books:generate -f
```

---

## **II. Tools**

### *II. a. Swagger*

- [**zircote.github.io/swagger-php**](https://zircote.github.io/swagger-php/): documentation of Swagger PHP
- [**github.com/DarkaOnLine/L5-Swagger**](https://github.com/DarkaOnLine/L5-Swagger): L5-Swagger repository

Generate documentation

```bash
php artisan l5-swagger:generate
```

dotenv variables

```js
L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_BASE_PATH=/api
```

### *II. b. Laravel Telescope (only useful in local)*

You can use [**laravel/telescope**](https://github.com/laravel/telescope) on Bookshelves at [**http://localhost:8000/telescope**](http://localhost:8000/telescope) if you serve project with `php artisan serve` (adapt URL if you have VHost).

In **dotenv** set `TELESCOPE_ENABLED` to `true`

```js
TELESCOPE_ENABLED=true
```

### *II. c. Spatie Media*

```bash
php artisan media-library:regenerate
```

### *II. d. Tests*

You can run Pest and PHP Unit tests

```bash
php artisan pest:run
```

---

## **III. `dotenv`**

For local

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

For production

```yml
APP_URL=https://bookshelves.git-projects.xyz

# ...

MAIL_USERNAME=<mail>
MAIL_PASSWORD=<mail>

L5_SWAGGER_GENERATE_ALWAYS=false
L5_SWAGGER_BASE_PATH=/api

SANCTUM_STATEFUL_DOMAINS=bookshelves.git-projects.xyz
SESSION_DOMAIN=.git-projects.xyz

TELESCOPE_ENABLED=false

RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
```
