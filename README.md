# Bookshelves · Back <!-- omit in toc -->

[![php](https://img.shields.io/static/v1?label=PHP&message=v8.0&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
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

- Multiple authors
- Fix sort by serie with article
- Sort by author, serie, title, language
- Setup cache
- Fix Resources collection with ResourceCollection extends
- Multiple author serie
- Logs for EpubParser

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

```bash
# for fresh installation (erase current database)
php artisan books:generate -f
```

```bash
# to parse all EPUB and create new entities only for unknown eBooks
php artisan books:generate
```

`php artisan books:generate` have some options

- `--f|fresh`: reset current database to fresh install
- `--d|debug`: default author pictures, basic covers only
- `--F|force`: skip confirm question for fresh prod

> You can use multiple options like `php artisan books:generate -fdF`

Execute tests

```bash
php artisan test:pest
```

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
