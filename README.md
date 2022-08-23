# **Useweb Back** <!-- omit in toc -->

[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.*&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![php](https://img.shields.io/static/v1?label=PHP&message=v8.1&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v9.*&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)

[![pnpm](https://img.shields.io/static/v1?label=pnpm&message=v7.*&color=F69220&style=flat-square&logo=pnpm&logoColor=ffffff)](https://pnpm.io)
[![node](https://img.shields.io/static/v1?label=Node.js&message=v16.*&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)

[![mysql](https://img.shields.io/static/v1?label=MySQL&message=v8.*&color=4479A1&style=flat-square&logo=mysql&logoColor=ffffff)](https://www.mysql.com)

📀 [**repository**](https://bitbucket.org/useweb/useweb-back)  
💻 [**www.useweb.fr/admin**](https://www.useweb.fr/admin)  

## **Setup**

Download dependencies.

```bash
composer i
cp .env.example .env
php artisan key:generate
php artisan storage:link
pnpm i
pnpm build
```

Create database `useweb`.

```bash
# .env
DB_DATABASE=useweb
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=Inbox-Name
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

APP_ADMIN_EMAIL=superadmin@example.com
APP_ADMIN_PASSWORD=password
```

```bash
php artisan migrate:fresh --seed
```

## **Serve**

```bash
php artisan serve
```

```bash
pnpm dev
```

Serve at <http://localhost:8000>, admin is available on <http://localhost:8000/admin>.

## **Production**

If admin not exist, you can insert it

```bash
php artisan db:seed --class=EmptySeeder
```

## **Tests**

Run tests.

```bash
composer test
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

## Notes

## questions

- posts: multi author instead two relations

### todo

- api doc
- pagination
- images resizing
- tests
- front views: livewire, alpine
