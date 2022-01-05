## **I. Store eBooks**

You have to check if `storage:link` is effective with

```bash
php artisan storage:link
```

**On Bookshelves you have to store your EPUB files into one directory: `public/storage/data/books`**

If you want to know why, it's simple, EPUB files aren't on git of course, but more it's not really practical to store all ebooks into Bookshelves directly, it's more convenient to set symbolic link from your eBooks storage which is not into Bookshelves. But you can store EPUB files into `public/storage/data/books` directory, of course, Bookshelves scan recursively this directory, you can have sub directories if you want.  

### *Option 1: store directly EPUB files*

Git won't track any file into `public/storage/data/books`

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- books
|         +-- my-ebook.epub
|         +-- ...
```

### *Option 2: create symbolic link*

This is best solution for my usage, I have some directories with different eBooks but I want to refer all these directories.

```bash
ln -s /any/directory/books-fantasy public/storage/data/books
ln -s /any/directory/books-classic public/storage/data/books
```

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- books
|         +-- books-fantasy -> /any/directory/books-fantasy
|         +-- books-classic -> /any/directory/books-classic
```

#### With variant: EPUB -> link

It's possible to link all EPUB files too but if you have any update from original directories, it can broke links or you have to link again.

```bash
ln -s /any/directory/books-fantasy/**/*.epub public/storage/data/books 
ln -s /any/directory/books-classic/**/*.epub public/storage/data/books
```

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- books
|         +-- my-ebook.epub -> /any/directory/books-fantasy/my-ebook.epub
|         +-- another-ebook.epub -> /any/directory/books-classic/another-ebook.epub
```

## **II. Custom data**

When Bookshelves parse EPUB to generate data, it will try to find extra data from Internet on GoogleBooks and Wikipedia. If you don't want to get these data, you can use `--local` option to skip it. But if you want to set custom data directly from parsing by Bookshelves, it's possible.

### *a. Description and link*

For extra data with authors and series for `description` and `link`, you can create JSON file. If an entry with `slug` of author or serie exist, Bookshelves will take it and don't use external API.

```bash
cp public/storage/data/authors.example.json public/storage/data/authors.json
cp public/storage/data/series.example.json public/storage/data/series.json
```

An example for authors.

```json
{
    "hugo-victor": {
        "description": "Victor Hugo est un poète, dramaturge, écrivain, romancier et dessinateur romantique français, né le 7 ventôse an X (26 février 1802) à Besançon et mort le 22 mai 1885 à Paris. Il est considéré comme l'un des plus importants écrivains de la langue française. Il est aussi une personnalité politique et un intellectuel engagé qui a eu un rôle idéologique majeur et occupe une place marquante dans l'histoire des lettres françaises au XIXe siècle.",
        "link": "https://gallica.bnf.fr"
    }
}
```

### *b. Picture*

Bookshelves will use cover of first book of a serie to generate cover's serie and will use Wikipedia API to get picture of an author. You can set custom pictures for series and authors. Just put **JPG** file with `slug` of author / serie into specific directory.

- `public/storage/data/pictures-authors`: for authors
- `public/storage/data/pictures-series`: for series

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- pictures-authors
|         +-- hugo-victor.jpg
|         +-- ...
```

You can set symbolic link like this to get pictures from another directory.

```bash
ln -s /any/directory/authors public/storage/data/pictures-authors
ln -s /any/directory/series public/storage/data/pictures-series
```

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- pictures-authors
|         +-- authors -> /any/directory/authors
```

## **III. Scan**

You can scan `books` directory to get a list of your EPUB files to know if everything works.

> -v is for verbose to get each file

```bash
php artisan bookshelves:scan -v
```

## **IV. Bookshelves commands**

Commands have some options, use `-h` to get list of all options.

### *a. generate*

**Main command of Bookshelves**, can parse all eBooks and **detect new eBooks** *OR* remove all eBooks data (and keep accounts) with `--fresh` like `php artisan bookshelves:generate -f`. When you want to detect new eBooks, just launch command without any option. It will launch multiple commands:

- `bookshelves:books`: parse all EPUB files, extract data, create relations and generate covers **if not exist**
- `bookshelves:series`: parse all series into database (don't create series) to generate cover and extra data **if haven't extra data**
- `bookshelves:authors`: parse all authors into database (don't create authors) to generate cover and extra data **if haven't extra data**

All these commands try to get extra data from Internet (Wikipedia and GoogleBooks), use `--local` like `php artisan bookshelves:generate -L` option to skip this feature.

>{--e|erase : erase all data}
>{--f|fresh : reset current books and relation, keep users}
>{--F|force : skip confirm question for prod}
>{--L|local : prevent external HTTP requests to public API for additional informations}
>{--d|debug : generate metadata files into public/storage/debug for debug}
>{--t|test : execute tests at the end}
>{--A|skip-admin : skip admin and roles generation}
>{--l|limit= : limit epub files to generate, useful for debug}

**WARNING**  
*`--l|limit=` option have to be set at the end of options*

*Example: here command will check only new eBooks*

```bash
php artisan bookshelves:generate
```

*Example: here command will*

- *erase all data with `migrate:fresh` with `-e` from bookshelves:books*
- *check all eBooks and erase books with relationships with `-f` from bookshelves:books*
- *books assets with `-b` from bookshelves:assets*
- *authors assets with `-a` from bookshelves:assets*
- *series assets with `-s` from bookshelves:assets*
- *comments with `-C` from bookshelves:sample*
- *selection with `-S` from bookshelves:sample*

```bash
php artisan bookshelves:generate -efbasCS
```

*Example: here command will use only local data with `-L`, get only 100 first EPUB files with `-l=100`*

```bash
php artisan bookshelves:generate -Ll=100
```

#### books

```bash
php artisan bookshelves:books
```

#### series

```bash
php artisan bookshelves:series
```

#### authors

```bash
php artisan bookshelves:authors
```

#### clear

```bash
php artisan bookshelves:clear
```

### *b. sample*

#### sample account data

```bash
php artisan bookshelves:sample
```

#### sample books

If you want to test Bookshelves, you can use `bookshelves:sample` to generate data from libre eBooks

```bash
php artisan bookshelves:sample-books
```

## **V. Extra commands**

### *a. Tests*

```bash
php artisan bookshelves:test
```

```bash
php artisan pest
```

```bash
php artisan larastan
```

### *b. Setup*

```bash
php artisan setup
```

### *c. Misc*

```bash
php artisan log:clear
```

```bash
php artisan log:read
```

## **VI. Features**

### *g. MetadataExtractor*

TODO

### *i. Wikipedia*

TODO

- WikipediaService
