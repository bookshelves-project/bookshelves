# Bookshelves · Back <!-- omit in toc -->

[![php](https://img.shields.io/static/v1?label=PHP&message=v8.0&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![mysql](https://img.shields.io/static/v1?label=MySQL&message=v8.0&color=4479A1&style=flat-square&logo=mysql&logoColor=ffffff)](https://www.mysql.com)

[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v8.0&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)
[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.16&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)
[![yarn](https://img.shields.io/static/v1?label=yarn&message=1.2&color=2C8EBB&style=flat-square&logo=yarn&logoColor=ffffff)](https://classic.yarnpkg.com/lang/en/)

📀 [**bookshelves-back**](https://gitlab.com/ewilan-riviere/bookshelves-back) : back-end of Bookshelves (current repository)  
🎨 [**bookshelves-front**](https://gitlab.com/ewilan-riviere/bookshelves-front) : front-end of Bookshelves  

💻 [**bookshelves.ink**](https://bookshelves.ink): front demo  
📚 [**bookshelves.ink/features**](https://bookshelves.ink/features): back-end features  

**Table of contents**

- [**Setup**](#setup)
  - [*a. Dependencies*](#a-dependencies)
  - [*b. Setup*](#b-setup)
- [**Usage**](#usage)

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

To get full documentation, you can read [**Wiki of Bookshelves**](https://bookshelves.ink/wiki), if this link is broken, you have to refer to [**raw documentation**](https://gitlab.com/ewilan-riviere/bookshelves-back/-/blob/master/resources/views/pages/wiki/content) on repository.
