# **Bookshelves** <!-- omit in toc -->

![banner](https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/public/vendor/images/banner-github.png)

[![laravel][laravel-version-src]][laravel-version-href]
[![php][php-version-src]][php-version-href]
[![filament][filament-version-src]][filament-version-href]
[![node][node-version-src]][node-version-href]
[![license][license-src]][license-href]
[![tests][tests-src]][tests-href]

[laravel-version-src]: https://img.shields.io/badge/dynamic/json?label=Laravel&query=require[%27laravel/framework%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&color=777bb4&logo=laravel&logoColor=ffffff&labelColor=18181b
[laravel-version-href]: https://laravel.com/
[php-version-src]: https://img.shields.io/badge/dynamic/json?label=PHP&query=require[%27php%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&color=777bb4&logo=&logoColor=ffffff&labelColor=18181b
[php-version-href]: https://www.php.net/
[node-version-src]: https://img.shields.io/badge/dynamic/json?label=Node.js&query=engines[%27node%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/package.json&color=777bb4&labelColor=18181b
[node-version-href]: https://nodejs.org/en
[filament-version-src]: https://img.shields.io/badge/dynamic/json?label=Filament&query=require[%27filament/filament%27]&url=https://raw.githubusercontent.com/bookshelves-project/bookshelves/main/composer.json&color=777bb4&logoColor=ffffff&labelColor=18181b
[filament-version-href]: https://filamentphp.com/
[tests-src]: https://img.shields.io/github/actions/workflow/status/bookshelves-project/bookshelves/ci.yml?branch=main&label=tests&style=flat-square&colorA=18181B
[tests-href]: https://github.com/bookshelves-project/bookshelves/actions/workflows/ci.yml
[license-src]: https://img.shields.io/github/license/bookshelves-project/bookshelves.svg?style=flat&colorA=18181B&colorB=777bb4
[license-href]: https://github.com/bookshelves-project/bookshelves/blob/main/LICENSE



- 📀 [**bookshelves-project**](https://github.com/bookshelves-project): Bookshelves project repository
- 💻 [**bookshelves.ink**](https://bookshelves.ink): demo
- 📚 [**bookshelves-documentation.netlify.app**](https://bookshelves-documentation.netlify.app): documentation from [this repository](https://github.com/bookshelves-project/bookshelves-doc)

## **Setup**

Download dependencies

```bash
composer i
pnpm i
```

Execute `setup` and follow guide

```bash
php artisan setup
```

See [**documentation**](https://bookshelves-documentation.netlify.app) to know more about _Bookshelves_.

## **Usage**

To get full documentation, you can read [**Bookshelves documentation**](https://bookshelves-documentation.netlify.app), if this link is broken, you have to refer to [**raw documentation**](https://github.com/bookshelves-project/bookshelves-doc) on repository.

## **Tests**

Run tests.

```bash
composer test
```

```bash
cp .env.testing.example .env.testing
```

```bash
php artisan migrate --env=testing
```

```bash
php artisan test
```

```bash
phpunit-watcher watch
```

### Watch

Install `spatie/phpunit-watcher` [GitHub](https://github.com/spatie/phpunit-watcher)

```bash
composer global require spatie/phpunit-watcher
```

And run tests.

```bash
composer test:watch
```
