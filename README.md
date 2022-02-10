# Bookshelves · Back <!-- omit in toc -->

[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![php](https://img.shields.io/static/v1?label=PHP&message=v8.0&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)

[![pnpm](https://img.shields.io/static/v1?label=pnpm&message=v6.2&color=F69220&style=flat-square&logo=pnpm)](https://pnpm.io)
[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=v16.13&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)

[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v8.0&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)
[![mysql](https://img.shields.io/static/v1?label=MySQL&message=v8.0&color=4479A1&style=flat-square&logo=mysql&logoColor=ffffff)](https://www.mysql.com)

📀 [**bookshelves-back**](https://gitlab.com/bookshelves-project/bookshelves-back) : back-end of Bookshelves (current repository)  
🎨 [**bookshelves-front**](https://gitlab.com/bookshelves-project/bookshelves-front) : front-end of Bookshelves  

💻 [**bookshelves.ink**](https://bookshelves.ink): front demo  
📚 [**documentation.bookshelves.ink**](https://documentation.bookshelves.ink): wiki  

## L9 upgrade

- documentation
  - <https://laravel-news.com/laravel-9-released>
  - <https://github.com/laravel/framework/pull/38538>
- `composer require`
  - `artesaos/seotools` <https://github.com/artesaos/seotools/pull/172>
  - `barryvdh/laravel-elfinder`
- `composer require --dev`
  - `barryvdh/laravel-ide-helper`
  - `beyondcode/laravel-dump-server` <https://github.com/beyondcode/laravel-dump-server/pull/82>
  - `spatie/phpunit-watcher`

**Table of contents**

- [L9 upgrade](#l9-upgrade)
- [**Setup**](#setup)
  - [*a. Dependencies*](#a-dependencies)
  - [*b. Setup*](#b-setup)
- [**Usage**](#usage)
- [**Tests**](#tests)

## **Setup**

### *a. Dependencies*

Extensions for PHP, here for `php8.0`

```bash
sudo apt-get install -y php8.0-xml php8.0-gd
```

For spatie image optimize tools

```bash
sudo apt-get install -y jpegoptim optipng pngquant optipng gifsicle webp
```

```bash
npm install -g svgo
```

### *b. Setup*

Download dependencies

```bash
composer install
```

Execute `setup` and follow guide

```bash
php artisan setup
```

## **Usage**

To get full documentation, you can read [**Wiki of Bookshelves**](https://bookshelves.ink/wiki), if this link is broken, you have to refer to [**raw documentation**](https://gitlab.com/bookshelves-project/bookshelves-back/-/blob/master/resources/views/pages/wiki/content) on repository.

## **Tests**

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
