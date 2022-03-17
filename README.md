# **Bookshelves · Back** <!-- omit in toc -->

[![composer](https://img.shields.io/static/v1?label=Composer&message=v2&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![php](https://img.shields.io/static/v1?label=PHP&message=v8.1&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v9.2&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)

[![pnpm](https://img.shields.io/static/v1?label=pnpm&message=v6&color=F69220&style=flat-square&logo=pnpm&logoColor=ffffff)](https://pnpm.io)
[![nodejs](https://img.shields.io/static/v1?label=Node.js&message=v16&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)
[![vuejs](https://img.shields.io/static/v1?label=Vue.js&message=v3.2&color=4FC08D&style=flat-square&logo=vue.js&logoColor=ffffff)](https://vuejs.org)

[![mysql](https://img.shields.io/static/v1?label=MySQL&message=v8&color=4479A1&style=flat-square&logo=mysql&logoColor=ffffff)](https://www.mysql.com)

📀 [**bookshelves-project**](https://gitlab.com/bookshelves-project): Bookshelves project  
💻 [**bookshelves.ink**](https://bookshelves.ink): demo  
📚 [**bookshelves-documentation.netlify.app**](https://bookshelves-documentation.netlify.app): documentation, if this link not work, you can check doc on [this repository](https://gitlab.com/bookshelves-project/bookshelves-doc)  

## **Setup**

### *a. Dependencies*

Extensions for PHP, here for `php8.1`

```bash
sudo apt-get install -y php8.1-xml php8.1-gd
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

To get full documentation, you can read [**Wiki of Bookshelves**](https://bookshelves-documentation.netlify.app), if this link is broken, you have to refer to [**raw documentation**](https://gitlab.com/bookshelves-project/bookshelves-doc) on repository.

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
