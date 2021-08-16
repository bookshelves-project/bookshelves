You need this to use Bookshelves

- Linux / macOS / Windows WSL
- PHP v8.0
- Composer v2.0
- MySQL v8.0
- NodeJS v14.16

# **I. Installation**

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

### Manual

Create `.env`

```bash
cp .env.example .env
```

Generate key

```bash
php artisan key:generate
```

Set database informations, you can set more data if you want, check [**II. .env**](#heading-iienv)

```bash
DB_DATABASE=<database_name>
DB_USERNAME=<database_user>
DB_PASSWORD=<database_password>
```

Download NodeJS dependencies

```bash
yarn
```

Execute Laravel mix

```bash
yarn dev
```

Generation API documentation

```bash
php artisan scribe:generate
```

Migrate database

```bash
php artisan migrate
```

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

## Common errors

## `webpack-cli` to install

```bash
> @ watch /path/to/bookshelves-back
> mix watch

npx: installed 73 in 4.909s
CLI for webpack must be installed.
  webpack-cli (https://github.com/webpack/webpack-cli)

We will use "pnpm" to install the CLI via "pnpm install -D webpack-cli".
Do you want to install 'webpack-cli' (yes/no):
```

If you have this request, you can accept but CLI will make request again and again... Install some dependencies globally to fix this problem

```bash
pnpm i -g cross-env laravel-mix webpack
```

# **II. Variables for .env**

## *a. Mails*

Bookshelves can send emails from contact form, you have to set `.env` variables.

*Example for local with [**mailtrap**](https://mailtrap.io/)*

```yaml
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=<mailtrap_email>
MAIL_PASSWORD=<mailtrap_password>
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@bookshelves.ink
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=contact@bookshelves.ink
MAIL_TO_NAME="${APP_NAME} contact"
```

*Example for production with [**mailgun**](https://www.mailgun.com/)*

You can use any other mailing service, it's just my configuration for Mailgun.

>For credentials
>
>- Create an account
>- After setup domain
>- Sending -> Domain settings -> SMTP credentials

```yaml
MAIL_MAILER=smtp
MAIL_HOST=smtp.eu.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=<mailgun_email>
MAIL_PASSWORD=<mailgun_password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@bookshelves.ink
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=contact@bookshelves.ink
MAIL_TO_NAME="${APP_NAME} contact"
```

## *b. Authentication*

Bookshelves use [**laravel/sanctum**](https://github.com/laravel/sanctum) for authentication with front-end which use [**nuxt/auth**](https://auth.nuxtjs.org/) to setup auth, you have to set correct variables into `.env` of back-end.

- `APP_URL`: URL of back-end
- `SANCTUM_STATEFUL_DOMAINS`: URL of front-end
- `SESSION_DOMAIN`: domain
- `ADMIN_EMAIL`: credential for `bookshelves:sample` to generate admin
- `ADMIN_PASSWORD`: password for admin

```yaml
APP_URL=http://localhost:8000

SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost

ADMIN_EMAIL=admin@mail.com
ADMIN_PASSWORD=password
```

In production with front-end at <https://bookshelves.ink>

```yaml
SANCTUM_STATEFUL_DOMAINS=bookshelves.ink
SESSION_DOMAIN=.bookshelves.ink
```

## **III. Webhook**

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
