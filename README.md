# **Bookshelves**

![banner](https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/public/vendor/images/banner-github.png)

[![php][php-version-src]][php-version-href]
[![laravel][laravel-version-src]][laravel-version-href]
[![filament][filament-version-src]][filament-version-href]
[![node][node-version-src]][node-version-href]
[![license][license-src]][license-href]
[![tests][tests-src]][tests-href]

Bookshelves is a web application to handle eBooks, comics and audiobooks. Powered by Laravel.

-   [**bookshelves-project**](https://github.com/bookshelves-project): Bookshelves project repository
-   [**bookshelves.ink**](https://bookshelves.ink): demo (front uses [`bookshelves-front`](https://github.com/bookshelves-project/bookshelves-front))
-   [**bookshelves-documentation.netlify.app**](https://bookshelves-documentation.netlify.app): documentation from [this repository](https://github.com/bookshelves-project/bookshelves-docs)

## Features

// TODO

### Roadmap

-   [ ] Add Docker installation option
-   [ ] Add Plex-like solution
-   [ ] Add tests

## Installation

Download dependencies

```bash
composer i
pnpm i
```

Create `.env` file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Create symbolic link for storage

```bash
php artisan storage:link
```

Migrate database with seeders

```bash
php artisan migrate:fresh --seed
```

Build assets

```bash
pnpm dev
```

### Add librairies

For books

```bash
BOOKSHELVES_LIBRARY_BOOKS=/path/to/books
BOOKSHELVES_LIBRARY_COMICS=/path/to/comics
BOOKSHELVES_LIBRARY_MANGAS=/path/to/mangas
BOOKSHELVES_LIBRARY_AUDIOBOOKS=/path/to/audiobooks
```

## Usage

Execute scan command to check if books are available, `-v` option for verbose mode

```bash
php artisan bookshelves:scan
```

And execute setup command to scan books and create database entries, `-f` option for fresh mode

```bash
php artisan bookshelves:setup -f
```

To get full documentation, you can read [**Bookshelves documentation**](https://bookshelves-documentation.netlify.app).

## Tests

Run tests.

```bash
composer test
```

## Environment

Bookshelves is powered by [`laravel`](https://laravel.com/) and administrator panel was built with [`filament`](https://filamentphp.com/).

Search engine uses [`meilisearch`](https://www.meilisearch.com/) with [`laravel/scout`](https://laravel.com/docs/master/scout).

EBooks, comics and audiobooks are handled by [`kiwilan/php-ebook`](https://github.com/kiwilan/php-ebook) and OPDS feature built by [`kiwilan/php-opds`](https://github.com/kiwilan/php-opds).

A lot of amazing [`spatie`](https://spatie.be/) packages are used in this project.

## License

The Bookshelves is open-sourced software licensed under the [BSD 2-Clause License](https://opensource.org/license/bsd-2-clause).

[laravel-version-src]: https://img.shields.io/badge/dynamic/json?label=Laravel&query=require[%27laravel/framework%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&color=777bb4&logo=laravel&logoColor=ffffff&labelColor=18181b
[laravel-version-href]: https://laravel.com/
[php-version-src]: https://img.shields.io/badge/dynamic/json?label=PHP&query=require[%27php%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&color=777bb4&logo=&logoColor=ffffff&labelColor=18181b
[php-version-href]: https://www.php.net/
[node-version-src]: https://img.shields.io/badge/dynamic/json?label=Node.js&query=engines[%27node%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/package.json&color=777bb4&labelColor=18181b
[node-version-href]: https://nodejs.org/en
[filament-version-src]: https://img.shields.io/badge/dynamic/json?label=Filament&query=require[%27filament/filament%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&color=777bb4&logoColor=ffffff&labelColor=18181b
[filament-version-href]: https://filamentphp.com/
[tests-src]: https://img.shields.io/github/actions/workflow/status/bookshelves-project/bookshelves/run-tests.yml?branch=main&label=tests&style=flat-square&colorA=18181B
[tests-href]: https://github.com/bookshelves-project/bookshelves/actions/workflows/ci.yml
[license-src]: https://img.shields.io/github/license/bookshelves-project/bookshelves.svg?style=flat&colorA=18181B&colorB=777bb4
[license-href]: https://github.com/bookshelves-project/bookshelves/blob/main/LICENSE
