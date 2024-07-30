# **Bookshelves**

![banner](https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/public/images/banner-github.jpg)

[![php][php-version-src]][php-version-href]
[![laravel][laravel-version-src]][laravel-version-href]
[![filament][filament-version-src]][filament-version-href]
[![node][node-version-src]][node-version-href]
[![license][license-src]][license-href]
[![tests][tests-src]][tests-href]

[Bookshelves](https://bookshelves.ink/) is a web application to handle eBooks, comics/mangas and audiobooks. Powered by [Laravel](https://laravel.com/).

-   [**bookshelves-project**](https://github.com/bookshelves-project): Bookshelves project repository
-   [**demo.bookshelves.ink**](https://demo.bookshelves.ink): demo
-   [**bookshelves-documentation.netlify.app**](https://bookshelves-documentation.netlify.app): documentation from [`bookshelves-project/bookshelves-docs`](https://github.com/bookshelves-project/bookshelves-docs)

## Features

-   All your books in one place, parsed by [`kiwilan/php-ebook`](https://github.com/kiwilan/php-ebook)
    -   Audiobooks: `.mp3`, `.m4b`
    -   Comics/Mangas: `.cb7`, `.cba`, `.cbr`, `.cbt`, `.cbz`
    -   eBooks: `.epub`, `.pdf`
-   Search engine with [Meilisearch](https://www.meilisearch.com/)
-   OPDS feed powered by [`kiwilan/php-opds`](https://github.com/kiwilan/php-opds)
-   Read eBooks, comics/mangas and listen audiobooks
-   Admin panel made by [`filament`](https://filamentphp.com/)
    -   Libraries management
    -   Users management
-   SSR option powered by [`inertia`](https://inertiajs.com/)

## Installation

### Docker

```sh
docker compose down --remove-orphans
docker compose up -d --build
```

Migrate database with seeders

```sh
docker compose exec app php artisan migrate:fresh --seed
```

Execute bash in the app container

```sh
docker container exec -it bookshelves /bin/zsh
```

### Logs

Check logs

```sh
docker logs bookshelves # docker logs bookshelves -f for live logs
```

### Roadmap

-   [ ] Add Docker installation option
-   [ ] Add Plex-like solution
-   [ ] Add tests
-   [ ] find duplicate authors
-   [ ] Read ebook in browser
-   [ ] Read comic in browser
-   [ ] Read audiobook in browser
-   [ ] Authentication

## Setup

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
pnpm build
```

Now you can serve application

```bash
php artisan serve
```

Bookshelves is now available at <http://localhost:8000> and you can access to the admin panel at <http://localhost:8000/admin>.

### Environment values

-   `APP_URL`: Application URL
-   `VITE_SSR_PORT`: Port for SSR, default is 13714 (only used in production, if you use SSR)
-   `SCOUT_DRIVER`: Search engine driver, default is `collection` depends of [Laravel Scout](https://laravel.com/docs/11.x/scout). Bookshelves use `meilisearch` driver.
-   `CLOCKWORK_ENABLE`: Enable or disable Clockwork, default is `false` (debug tool)
-   `BOOKSHELVES_SUPER_ADMIN_EMAIL`: Super admin email, used to create the first user
-   `BOOKSHELVES_SUPER_ADMIN_PASSWORD`: Super admin password, used to create the first user
-   `BOOKSHELVES_ANALYZER_ENGINE`: Analyzer engine, default is `native` (`native` or [`scout`](https://github.com/ewilan-riviere/scout))
-   `BOOKSHELVES_ANALYZER_DEBUG`: Analyzer debug mode, default is `false` (print a JSON file for each book analyzed)
-   `BOOKSHELVES_IMAGE_CONVERSION`: Image conversion engine, default is `false` (convert covers to different sizes)
-   `BOOKSHELVES_API_WIKIPEDIA`: use Wikipedia API to get author information and photos, default is `true`

### Add librairies

You have two solutions to create libraries: create a JSON file or use the admin panel (you can add libraries even if you use JSON file).

#### Admin panel

Connect to the admin panel at <http://localhost:8000/admin> with the default credentials defined in `.env` file (`BOOKSHELVES_SUPER_ADMIN_EMAIL` and `BOOKSHELVES_SUPER_ADMIN_PASSWORD`).

Go to the admin panel at <http://localhost:8000/admin>, find the `Libraries` entry in the sidebar and click on `New library`.

-   `Name` is a label for your library
-   `Type` is a select with `audiobook`, `book` and `comic_manga` values.
-   `Path` is absolute path to your library
-   `Slug` is defined automatically from the name field
-   `Enabled` is a checkbox to enable or disable the library
-   `Path is valid` is a read-only field to check if the path is valid (automatically checked when you save the library)

#### JSON file

Create a `libraries.json` file from `libraries-template.json`.

```bash
cp libraries-template.json libraries.json
```

And add your books libraries in `libraries.json`.

-   `name`: Library name, you can use any label
-   `type`: `LibraryTypeEnum` (`audiobook`, `book`, `comic_manga`)
-   `path`: Absolute path to your library
-   `is_enabled`: Optional, to enable or disable the library

```json
[
    {
        "name": "My audiobooks",
        "type": "audiobook", // LibraryTypeEnum: audiobook, book, `comic_manga`
        "path": "/absolute/path/to",
        "is_enabled": true // optional, to enable or disable the library
    }
    // ...
]
```

And when you execute the analyze command with `--fresh` option, Bookshelves will create database entries for each library and will scan books.

## Usage

### Analyze

Execute analyze command to analyze books and create database entries.

-   `-f|--fresh` option for fresh mode (delete all books before analyze)
-   `-l|--limit` option for limit mode (limit the number of books to analyze)

```bash
php artisan bookshelves:analyze -f
```

To get full documentation, you can read [**Bookshelves documentation**](https://bookshelves-documentation.netlify.app).

### Preview

Execute scan command to get a preview of scannable books (libraries have to be created).

-   `-v` option for verbose mode

```bash
php artisan bookshelves:scan
```

## Tests

Create a `.env.testing` file

```bash
cp .env.testing.example .env.testing
```

Create key for testing

```bash
php artisan key:generate --env=testing
```

Run tests

```bash
composer test
```

## Credits

-   [`laravel`](https://laravel.com/) for a powerful framework
-   [`filament`](https://filamentphp.com/) for a so efficient admin panel
-   [`spatie`](https://github.com/spatie) for a lot of amazing packages
-   [`tailwindcss`](https://tailwindcss.com/) for a so easy to use CSS framework
-   [`vue`](https://vuejs.org/) for a so amazing JavaScript framework
-   [`inertia`](https://inertiajs.com/) for a so efficient way to build modern monolithic applications
-   [`meilisearch`](https://www.meilisearch.com/) for a fast and relevant search engine
-   [`kiwilan/php-ebook`](https://github.com/kiwilan/php-ebook) for a PHP eBook parser
-   [`kiwilan/php-opds`](https://github.com/kiwilan/php-opds) for a PHP OPDS feed generator
-   [`ewilan-riviere`](https://github.com/ewilan-riviere) author of Bookshelves

## License

The Bookshelves is open-sourced software licensed under the [BSD 2-Clause License](https://opensource.org/license/bsd-2-clause).

[laravel-version-src]: https://img.shields.io/badge/dynamic/json?label=Laravel&query=require[%27laravel/framework%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&style=flat-square&color=777bb4&logo=laravel&logoColor=ffffff&labelColor=18181b
[laravel-version-href]: https://laravel.com/
[php-version-src]: https://img.shields.io/badge/dynamic/json?label=PHP&query=require[%27php%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&style=flat-square&color=777bb4&logo=&logoColor=ffffff&labelColor=18181b
[php-version-href]: https://www.php.net/
[node-version-src]: https://img.shields.io/badge/dynamic/json?label=Node.js&query=engines[%27node%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/package.json&style=flat-square&color=777bb4&labelColor=18181b
[node-version-href]: https://nodejs.org/en
[filament-version-src]: https://img.shields.io/badge/dynamic/json?label=Filament&query=require[%27filament/filament%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&style=flat-square&color=777bb4&logoColor=ffffff&labelColor=18181b
[filament-version-href]: https://filamentphp.com/
[license-src]: https://img.shields.io/github/license/bookshelves-project/bookshelves.svg?style=flat-square&colorA=18181B&colorB=777BB4
[license-href]: https://github.com/bookshelves-project/bookshelves/blob/main/README.md
[tests-src]: https://gitlab.com//badges/main/pipeline.svg
[tests-href]: https://gitlab.com/bookshelves-project/bookshelves/-/jobs

<!-- [tests-src]: https://img.shields.io/github/actions/workflow/status/bookshelves-project/bookshelves/run-tests.yml?branch=main&label=tests&style=flat-square&colorA=18181B -->
<!-- [tests-href]: https://github.com/bookshelves-project/bookshelves/actions/workflows/ci.yml -->
