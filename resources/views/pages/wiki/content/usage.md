# **I. Store eBooks**

You have to check if `storage:link` is effective with

```bash
php artisan storage:link
```

**On Bookshelves you have to store your EPUB files into one directory: `public/storage/raw/books`**

If you want to know why, it's simple, EPUB files aren't on git of course, but more it's not really practical to store all ebooks into Bookshelves directly, it's more convenient to set symbolic link from your eBooks storage which is not into Bookshelves. But you can store EPUB files into `public/storage/raw/books` directory, of course, Bookshelves scan recursively this directory, you can have sub directories if you want.  

## *Option 1: store directly EPUB files*

Git won't track any file into `public/storage/raw/books`

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- books
|         +-- my-ebook.epub
|         +-- ...
```

## *Option 2: create symbolic link*

This is best solution for my usage, I have some directories with different eBooks but I want to refer all these directories.

```bash
ln -s /any/directory/books-fantasy public/storage/raw/books
ln -s /any/directory/books-classic public/storage/raw/books
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

### With variant: EPUB -> link

It's possible to link all EPUB files too but if you have any update from original directories, it can broke links or you have to link again.

```bash
ln -s /any/directory/books-fantasy/**/*.epub public/storage/raw/books 
ln -s /any/directory/books-classic/**/*.epub public/storage/raw/books
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

# **II. Scan**

You can scan `books` directory to get a list of your EPUB files to know if everything works.

> -v is for verbose to get each file

```bash
php artisan bookshelves:scan -v
```

# **III. Bookshelves commands**

Commands have some options, use `-h` to get list of all options.

## *a. start*

`bookshelves:start` will delete ALL DATA with `migrate:fresh --force` and ALL MEDIA from `public/storage/media`, it's useful for initialization of Bookshelves or if you want to refresh all data without keeping accounts data. It will launch multiple commands:

- `bookshelves:generate`
- `bookshelves:sample`

>--r|roles : generate roles  
>--u|users : generate users with roles  
>--a|account : generate fake comments, favorites sample (users with roles will be generated)  
>--s|selection : generate fake selection sample (users with roles will be generated)  
>--L|local : prevent external HTTP requests to public API for additional informations  
>--l|limit= : limit epub files to generate, useful for debug  
>--d|debug : generate metadata files into public/storage/debug for debug  
>--t|test : execute tests at the end  

*Example: here `-as` will generate account data and selection books with users*

```bash
php artisan bookshelves:start -as
```

## *b. generate*

**Main command of Bookshelves**, can parse all eBooks and **detect new eBooks** *OR* remove all eBooks data (and keep accounts) with `--fresh` like `php artisan bookshelves:generate -f`. When you want to detect new eBooks, just launch command without any option. It will launch multiple commands:

- `bookshelves:books`: parse all EPUB files, extract data, create relations and generate covers **if not exist**
- `bookshelves:series`: parse all series into database (don't create series) to generate cover and extra data **if haven't extra data**
- `bookshelves:authors`: parse all authors into database (don't create authors) to generate cover and extra data **if haven't extra data**

All these commands try to get extra data from Internet (Wikipedia and GoogleBooks), use `--local` like `php artisan bookshelves:generate -L` option to skip this feature.

>--f|fresh : reset current books and relation, keep users  
>--F|force : skip confirm question for prod  
>--c|covers : prevent generation of covers  
>--L|local : prevent external HTTP requests to public API for additional informations  
>--l|limit= : limit epub files to generate, useful for debug  
>--d|debug : generate metadata files into public/storage/debug for debug  
>--t|test : execute tests at the end  

*Example: here command will check only new eBooks*

```bash
php artisan bookshelves:generate
```

### books

```bash
php artisan bookshelves:books
```

### series

```bash
php artisan bookshelves:series
```

### authors

```bash
php artisan bookshelves:authors
```

### clear

```bash
php artisan bookshelves:clear
```

## *c. sample*

### sample account data

```bash
php artisan bookshelves:sample
```

### sample books

If you want to test Bookshelves, you can use `bookshelves:sample` to generate data from libre eBooks

```bash
php artisan bookshelves:sample-books
```

# **IV. Extra commands**

## *a. Tests*

```bash
php artisan bookshelves:test
```

```bash
php artisan pest
```

```bash
php artisan larastan
```

## *b. Setup*

```bash
php artisan setup
```

## *c. Misc*

```bash
php artisan webreader:clear
```

```bash
php artisan log:clear
```

```bash
php artisan log:read
```

# **V. Features**

## *g. MetadataExtractor*

TODO

## *i. Wikipedia*

TODO

- WikipediaProvider
