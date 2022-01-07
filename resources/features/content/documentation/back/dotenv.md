`dotenv` is the name of `.env` file at the root app.

## General informations

- `APP_NAME`: Name of the app
- `APP_ENV`: `local` or `production` to define app behavior
- `APP_DEBUG`: to get error message instead of error 500 page
- `APP_URL`: root app URL
- `APP_REPOSITORY_URL`: URL of repository

```yml
APP_NAME=Bookshelves
APP_ENV=local
## ...
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_REPOSITORY_URL=https://gitlab.com/bookshelves-project/bookshelves-back
```

## Database

- `DB_DATABASE`: your database name
- `DB_USERNAME`: your username for database
- `DB_PASSWORD`: your password for username

```yml
DB_DATABASE=bookshelves
DB_USERNAME=root
DB_PASSWORD=
```

## *a. Mails*

Bookshelves can send emails from contact form, you have to set `.env` variables.

*Example for local with [**mailtrap**](https://mailtrap.io/)*

```yml
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
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

- `SANCTUM_STATEFUL_DOMAINS`: URL of front-end
- `SESSION_DOMAIN`: domain

```yaml
SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=null
```

In production with front-end at <https://bookshelves.ink>

```yaml
SANCTUM_STATEFUL_DOMAINS=bookshelves.ink
SESSION_DOMAIN=.bookshelves.ink
```

## Local options

Set all these options to `false` into production

- `BROWSER_SYNC`: enable Browsersync* with `yarn watch`
- `TELESCOPE_ENABLED`:
- `CLOCKWORK_ENABLE`:

```yml
BROWSER_SYNC=true
TELESCOPE_ENABLED=false
CLOCKWORK_ENABLE=true
```

*: You have to serve with `php artisan serve`

## Bookshelves options

You cna have more details in `config/bookshelves.php`

- `BOOKSHELVES_ADMIN_EMAIL`: generated admin account for back-office
- `BOOKSHELVES_ADMIN_PASSWORD`: admin password
- `BOOKSHELVES_COVER_FORMAT`: default image format for covers
- `BOOKSHELVES_AUTHOR_ORDER_NATURAL`: if your eBooks have authors with 'firstname-lastname', set false if the order is reverse
- `BOOKSHELVES_AUTHOR_DETECT_HOMONYMS`: if true, 'Victor Hugo' and 'Hugo Victor' will be detected as same author, if false, two authors will be created
- `BOOKSHELVES_LANGS`: Bookshelves accept any lang from eBooks but langs here can have nice name, can be not set to get default langs of app
- `BOOKSHELVES_TAGS_GENRES`: genres list, can be not set to get default langs of app
- `BOOKSHELVES_TAGS_FORBIDDEN`: forbidden tags, can be not set to get default langs of app

```yml
BOOKSHELVES_ADMIN_EMAIL=admin@mail.com
BOOKSHELVES_ADMIN_PASSWORD=password
BOOKSHELVES_COVER_FORMAT=webp
BOOKSHELVES_AUTHOR_ORDER_NATURAL=true
BOOKSHELVES_AUTHOR_DETECT_HOMONYMS=true
## BOOKSHELVES_LANGS=fr.French,en.English
## BOOKSHELVES_TAGS_GENRES="Action & adventures,Crime & mystery,Fantasy,Horror,Romance,Science fiction"
## BOOKSHELVES_TAGS_FORBIDDEN="SF,General"
```

## Search engine

Search engine works with [**laravel/scout**](https://laravel.com/docs/8.x/scout). You can use [**meilisearch**](https://www.meilisearch.com/) with Bookshelves, set `SCOUT_DRIVER=meilisearch`, but if you don't want to use this engine, you can use default search engine with `SCOUT_DRIVER=collection`.

```yml
SCOUT_DRIVER=collection ## meilisearch/algolia/collection
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=
SCOUT_QUEUE=false
```
