You need this to use Bookshelves

- Linux / macOS / Windows WSL
- PHP v8.0
- Composer v2.0
- MySQL v8.0
- NodeJS v14.16
- Yarn v1.2

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

# **II. Variables for .env**

## *a. For local*

```yaml
APP_URL=http://localhost:8000

SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost

TELESCOPE_ENABLED=true

BOOKSHELVES_ADMIN_EMAIL=admin@mail.com
BOOKSHELVES_ADMIN_PASSWORD=password
```

Setup for [**Mailtrap**](https://mailtrap.io/)

```yaml
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=mailtrap_username
MAIL_PASSWORD=mailtrap_password
MAIL_FROM_ADDRESS=noreply@bookshelves.ink
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=contact@bookshelves.ink
MAIL_TO_NAME="${APP_NAME}"
```

## *b. For production*

```yaml
APP_URL=https://www.mydomain.com

SANCTUM_STATEFUL_DOMAINS=www.mydomain.com
SESSION_DOMAIN=.mydomain.com

TELESCOPE_ENABLED=false
```

Setup for [**Mailgun**](https://www.mailgun.com/)

For credentials

- Create an account
- After setup domain
- Sending -> Domain settings -> SMTP credentials

```yaml
MAIL_HOST=smtp.eu.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=mailgun_user_login
MAIL_PASSWORD=mailgun_user_password
MAIL_FROM_ADDRESS=noreply@bookshelves.ink
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=contact@bookshelves.ink
MAIL_TO_NAME="${APP_NAME}"
```
