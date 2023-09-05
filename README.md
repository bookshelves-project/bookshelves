# **Bookshelves** <!-- omit in toc -->

[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.x&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![php](https://img.shields.io/static/v1?label=PHP&message=v8.2&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v10.x&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)

[![pnpm](https://img.shields.io/static/v1?label=pnpm&message=v8.x&color=F69220&style=flat-square&logo=pnpm&logoColor=ffffff)](https://pnpm.io)
[![node](https://img.shields.io/static/v1?label=Node.js&message=v18.x&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)

📀 [**bookshelves-project**](https://github.com/bookshelves-project): Bookshelves project repository
💻 [**bookshelves.ink**](https://bookshelves.ink): demo
📚 [**bookshelves-documentation.netlify.app**](https://bookshelves-documentation.netlify.app): documentation from [this repository](https://github.com/bookshelves-project/bookshelves-doc)

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

## Meilisearch

Bookshelves use [Meilisearch](https://www.meilisearch.com/docs) with `v0.27.0` version.

```bash
sudo docker run -d --rm \
    -p 7700:7700 \
    -e MEILI_ENV='production'\
    -e MEILI_MASTER_KEY='MASTER_KEY'\
    -v $(pwd)/meili_data:/meili_data \
    --name meilisearch-v0 \
    getmeili/meilisearch:v0.27.0
```

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
