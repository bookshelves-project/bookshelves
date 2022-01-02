Search engine on Bookshelves use [**laravel/scout**](https://laravel.com/docs/8.x/scout) which can use Algolia or Meilisearch to use powerful search engine. If you want to use only embedded search engine, you can just set `SCOUT_DRIVER` into `.env` to `collection`, less efficient than meilisearch but useful for search.

```yml
# to use meilisearch
SCOUT_DRIVER=meilisearch
```

```yml
# to use embedded search engine
SCOUT_DRIVER=collection
```

## Install

You have to install [**meilisearch**](https://www.meilisearch.com/) from [**this guide**](https://docs.meilisearch.com/learn/getting_started/installation.html), you can install it on Linux as service.

Download `meilisearch` via `curl`

```bash
curl -L https://install.meilisearch.com | sh
```

Move it to binaries

```bash
sudo mv meilisearch /usr/bin/
```

Execute it from anywhere

```bash
meilisearch
```

To create a service for production, check [**official guide**](https://docs.meilisearch.com/create/how_to/running_production.html)

### macOS

You can use `brew` to install meilisearch

```bash
brew update && brew install meilisearch
```

### Windows

You can install Ubuntu or Debian with [**WSL**](https://docs.microsoft.com/en-us/windows/wsl/install-manual) and install meilisearch.

## Import models

You can import `Book`, `Author` and `Serie` with bookshelves command.

```bash
php artisan bookshelves:scout
```

## Usage

If you have an meilisearch instance, you can check it to <http://127.0.0.1:7700>. If importation works, you will see three indexes for `Book`, `Author` and `Serie` and you can search into each index.

On `.env`, you have to set some variables

```yml
SCOUT_DRIVER=meilisearch # meilisearch/algolia/collection
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=
SCOUT_QUEUE=false
```

Into a controller, you can search with `search` method

```php
Book::search('any search')->get();
```

### Customize fields

Meilisearch check all fields but you can limit it with `toSearchableArray`

```php
public function toSearchableArray()
{
  return [
    'id' => $this->id,
    'title' => $this->title,
    'date' => $this->date,
    'author' => $this->authors_names,
    'created_at' => $this->created_at,
    'updated_at' => $this->updated_at,
  ];
}
```

And execute again `scout` command with `php artisan booksheves:scout`

## Troubles

### No indexes on Meilisearch

If you don't see indexes on <http://127.0.0.1:7700>, it may be cause by cache.

```bash
php artisan cache:clear
```

Check if `bootstrap/cache` is empty, if it's not works check variables on [**home**](/features)
