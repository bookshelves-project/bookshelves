# Bookshelves · Back <!-- omit in toc -->

[![php](https://img.shields.io/static/v1?label=PHP&message=v7.4&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)  
[![laravel](https://img.shields.io/static/v1?label=Laravel&message=8.0&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)
[![swagger](https://img.shields.io/static/v1?label=Swagger&message=v3.0&color=85EA2D&style=flat-square&logo=swagger&logoColor=ffffff)](https://swagger.io)

[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.15&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)
[![yarn](https://img.shields.io/static/v1?label=Yarn&message=v1.2&color=2C8EBB&style=flat-square&logo=yarn&logoColor=ffffff)](https://yarnpkg.com/lang/en/)

- 📀 [**bookshelves-back**](https://gitlab.com/EwieFairy/bookshelves-back) : back-end of Bookshelves (current repository)
- 🎨 [**bookshelves-front**](https://gitlab.com/EwieFairy/bookshelves-front) : front-end of Bookshelves
- 💻 [**bookshelves.git-projects.xyz**](https://bookshelves.git-projects.xyz) : preprod
- 📚 [**Documentation**](https://bookshelves.git-projects.xyz/api/documentation)

**Table of contents**

- [**TODO**](#todo)
- [**I. Setup**](#i-setup)
- [**II. Swagger**](#ii-swagger)

---

## **TODO**

- Sort by author, serie, title, language
- Setup cache

---

## **I. Setup**

Prerequisites for XML parse, spatie image optimize tools, here for `php7.4`

```bash
sudo apt-get install -y php7.4-xml php7.4-gd ; sudo apt-get install -y jpegoptim optipng pngquant gifsicle webp ; npm install -g svgo
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

```bash
php artisan books:generate --fresh
```

> `--fresh` option will erase current database, use `php artisan books:generate` to generate only new books from unknown EPUB

## **II. Swagger**

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
