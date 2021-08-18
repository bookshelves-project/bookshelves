# **I. Auth**

[**laravel/sanctum**](https://github.com/laravel/sanctum): Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform.

Routes can be protected like this

```php
Route::middleware(['auth:sanctum'])->group(function () {
  // routes
}
```

## Login 419 error: "CSRF token mismatch"

```bash
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan optimize:clear
```

# **II. API documentation**

[**knuckleswtf/scribe**](https://github.com/knuckleswtf/scribe): Scribe helps you generate API documentation for humans from your Laravel/Lumen/Dingo codebase. See a live example at [demo.scribe.knuckles.wtf](https://demo.scribe.knuckles.wtf).

If you use `php artisan serve`, knuckleswtf/scribe is available on `/docs`, like [**localhost:8000/docs**](http://localhost:8000/docs). You can set parameters into each Controller, check [**scribe.knuckles.wtf/laravel**](https://scribe.knuckles.wtf/laravel/) to know more, like this

```php
<?php

/**
 * @group Author
 *
 * Endpoint to get Authors data.
 */
class AuthorController extends Controller
{
  /**
   * GET Author collection
   *
   * <small class="badge badge-blue">WITH PAGINATION</small>
   *
   * You can get all Authors with alphabetic order on lastname with pagination.
   *
   * @queryParam per-page int Entities per page, '32' by default. No-example
   * @queryParam page int The page number, '1' by default. No-example
   * @responseFile public/storage/responses/authors.index.get.json
   */
  public function index(Request $request)
  {
    // ...
  }
}
```

## Generate documentation

```bash
php artisan scribe:generate
```

# **III. Code linter**

## IDE helper

[**barryvdh/laravel-ide-helper**](https://github.com/barryvdh/laravel-ide-helper): to generate magic methods for each model to help IDE completion

```bash
composer helper
```

## larastan

[**nunomaduro/larastan**](https://github.com/nunomaduro/larastan): Adds static analysis to Laravel improving developer productivity and code quality.

```bash
php artisan larastan
```

## PHP CS Fixer

[**friendsofphp/php-cs-fixer**](https://github.com/friendsofphp/php-cs-fixer): A tool to automatically fix PHP Coding Standards issues

```bash
composer helper
```

# **IV. Database and models**

- [**fakerphp/faker**](https://github.com/fakerphp/faker): Faker is a PHP library that generates fake data for you

## Enum

[**spatie/laravel-enum**](https://github.com/spatie/laravel-enum): Laravel support for spatie/enum

## Media library

[**spatie/laravel-medialibrary**](https://github.com/spatie/laravel-medialibrary): Associate files with Eloquent models. If you update `registerMediaConversions()` in any Model, you can regenerate conversions

```bash
php artisan media-library:regenerate
```

## Tags

[**spatie/laravel-tags**](https://github.com/spatie/laravel-tags): Add tags and taggable behaviour to your Laravel app

# **V. Tools**

## Clockwork

[**itsgoingd/clockwork**](https://github.com/itsgoingd/clockwork): Clockwork is a development tool for PHP available right in your browser. Clockwork gives you an insight into your application runtime - including request data, performance metrics, log entries, database queries, cache queries, redis commands, dispatched events, queued jobs, rendered views and more - for HTTP requests, commands, queue jobs and tests.

To use Clockwork, you have to install browser extension: [**Chrome**](https://chrome.google.com/webstore/detail/clockwork/dmggabnehkmmfmdffgajcflpdjlnoemp) or [**Firefox**](https://addons.mozilla.org/en-US/firefox/addon/clockwork-dev-tools/). When it's done, just open DevTools and choose Clockwork.

## CORS

[**fruitcake/laravel-cors**](https://github.com/fruitcake/laravel-cors): Adds CORS (Cross-Origin Resource Sharing) headers support in your Laravel application

## Images

- [**spatie/image**](https://github.com/spatie/image): Manipulate images with an expressive API
- [**oscarotero/inline-svg**](https://github.com/oscarotero/inline-svg): Insert svg in the html so you can use css to change the style
- [**spatie/laravel-image-optimizer**](https://github.com/spatie/laravel-image-optimizer): Optimize images in your Laravel app

## Markdown

- [**thephpleague/commonmark**](https://github.com/thephpleague/commonmark): Highly-extensible PHP Markdown parser which fully supports the CommonMark and GFM specs.
- [**spatie/commonmark-highlighter**](https://github.com/spatie/commonmark-highlighter): Highlight code blocks with league/commonmark
- [**thephpleague/html-to-markdown**](https://github.com/thephpleague/html-to-markdown): Convert HTML to Markdown with PHP
- [**spatie/laravel-markdown**](https://github.com/spatie/laravel-markdown): A highly configurable markdown renderer and Blade component for Laravel

## XML

[**spatie/array-to-xml**](https://github.com/spatie/array-to-xml): A simple class to convert an array to xml

## Routing

[**spatie/laravel-route-attributes**](https://github.com/spatie/laravel-route-attributes): Use PHP 8 attributes to register routes in a Laravel app

## Telescope

*Only available on `routes/web.php`*

- [**laravel/telescope**](https://github.com/laravel/telescope): Telescope makes a wonderful companion to your local Laravel development environment. Telescope provides insight into the requests coming into your application, exceptions, log entries, database queries, queued jobs, mail, notifications, cache operations, scheduled tasks, variable dumps, and more.
- [**fruitcake/laravel-telescope-toolbar**](https://github.com/fruitcake/laravel-telescope-toolbar): A toolbar for Laravel Telescope, based on the Symfony Web Profiler.

To enable Telescope, just change variable in `.env`

```yaml
TELESCOPE_ENABLED=true
```

*Note: only useful in local*

You can use [**laravel/telescope**](https://github.com/laravel/telescope) on Bookshelves at [**http://localhost:8000/telescope**](http://localhost:8000/telescope) if you serve project with `php artisan serve` (adapt URL if you have VHost).

# **VI. Tests**

- [**phpunit.de**](https://phpunit.de): `phpunit/phpunit` package doc
- [**pestphp.com**](https://pestphp.com): `pestphp/pest` package doc

```bash
php artisan migrate --database=testing
```

You can run Pest and PHP Unit tests

```bash
php artisan pest:run
```
