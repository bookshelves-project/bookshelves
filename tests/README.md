# Tests

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