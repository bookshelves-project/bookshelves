You need this to use Bookshelves

- 💻 Linux / macOS / Windows WSL
- 🐘 PHP v8.0 : [php.net](https://www.php.net)
- 🎶 Composer v2.0 : [getcomposer.org](https://getcomposer.org)
- 🐬 MySQL v8.0 : [mysql.com](https://www.mysql.com)
- 🟢 NodeJS v14.16 : [nodejs.org](https://nodejs.org/en)
- 🧶 yarn v1.2 : [classic.yarnpkg.com](https://classic.yarnpkg.com/lang/en/)

## *a. Dependencies*

Extensions for PHP, here for `php8.0`

```bash
sudo apt-get install -y php8.0-xml php8.0-gd
```

For spatie image optimize tools

```bash
sudo apt-get install -y jpegoptim optipng pngquant gifsicle webp
```

```bash
npm install -g svgo
```

## *b. Setup*

Download dependencies

```bash
composer install
```

### Setup command (easy way)

Execute `setup` and follow guide

```bash
php artisan setup
```

**About environment variables, you can check [.env page](/features/wiki/dotenv)**

### Manual

Create `.env`

```bash
cp .env.example .env
```

Set database informations in `.env`

```yml
DB_DATABASE=bookshelves
DB_USERNAME=root
DB_PASSWORD=
```

**For more details you can check [.env page](/features/wiki/dotenv)**

Generate key

```bash
php artisan key:generate
```

Download NodeJS dependencies

```bash
yarn
```

Generation API documentation

```bash
php artisan scribe:generate
```

Migrate database

```bash
php artisan migrate
```

Execute Laravel mix

```bash
yarn prod
```

Serve app

```bash
php artisan serve
```

Your app is available at <http://localhost:8000>

## Production rights

For Linux Debian-like only, give rights for `www-data` group on `storage` and `bootstrap/cache`

```bash
chown -R $USER:www-data *
chmod -R ug+rwx storage bootstrap/cache
```

**WARNING** use this command if you haven't any custom changement
Previous command will add tracking changes for git, skip it with this command

```bash
git checkout .
```

## Assets

Execute Laravel mix

```bash
yarn dev
```

Minified for prod

```bash
yarn prod
```

To have [**Browsersync**](https://browsersync.io/), you have to serve app with `php artisan serve` at <http://localhost:8000>

```bash
yarn watch
```

You app with [**Browsersync**](https://browsersync.io/) is on <http://localhost:8001>

## Webhook

If you use Webhook to get update from your git forge, you can setup `.git/hooks/post-merge` with this config

```bash
#!/bin/bash

php artisan cache:clear
php artisan config:clear
php artisan view:clear

composer install
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan scribe:generate

yarn
yarn prod
```
