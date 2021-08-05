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

# **III. Commands**

## *a. Start*

```bash
php artisan bookshelves:start -uf
```

## *b. Generate*

```bash
php artisan bookshelves:generate -fF
```

# *b. Test with demo eBook*

If you want to test Bookshelves, you can use `bookshelves:sample` to generate data from libre eBooks

> `php artisan bookshelves:sample -h` to check options

```bash
php artisan bookshelves:sample
```

# *e. Mails*

TODO

# *g. MetadataExtractor*

TODO

# *i. Wikipedia*

TODO

- WikipediaProvider
