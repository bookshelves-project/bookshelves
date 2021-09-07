
# **Roadmap**

This is roadmap for Bookshelves development, all planned features will be listed here. You can add an issue here to ask for new feature [**bookshelves-back: add issue**](https://gitlab.com/ewilan-riviere/bookshelves-back/-/issues).

## *Back*

- [ ] Meilisearch to replace native search
- [ ] i18n for back features
- [ ] rewrite ebook parsing engine
- [ ] back-office with datatables
- API doc
  - [ ] improve doc responseField
  - [ ] improve bind routes
- [ ] Logs for EpubParser
- [ ] Improve libre ebooks meta
- [ ] Add attribute on each method for Controller
- [ ] Add explanation form each part of EpubParser
- [ ] larastan upgrade level
- [ ] more tests for models
- [ ] authors notes WIP
- [ ] [opds](https://specs.opds.io/opds-1.2)

## *Front*

- [ ] admin for front
  - [ ] selection books
  - [ ] update no ebooks entities
- [ ] add last books added with random book cta
- [ ] add i18n
- Improve design
  - [ ] buttons on book details stealth
  - [ ] review agile book selection (with vol 0)
  - [ ] agile language flag to text
  - [ ] review blocks order book detail (masonry or tailwind)
  - [ ] book detail agile same page refer change
  - [ ] book detail current vol remove
  - [ ] book list filter remove (refresh page not appear)
  - [ ] book list hover dark
  - [ ] content custom component for zoom on img
  - [ ] last books, book selection on home
  - [ ] list min height
  - [ ] search improve with options, add text to explain, change no result text
  - [ ] paginate design color for not available page
  - [ ] settings, update website name for vivacia
  - [ ] review title by og
  - [ ] jsonld, sitelinks
  - [ ] fix route generate

# **Notes**

This is notes about concepts.

- Check attributes
  - [amitmerchant.com/how-to-use-php-80-attributes](https://www.amitmerchant.com/how-to-use-php-80-attributes)
  - [stitcher.io/blog/attributes-in-php-8](https://stitcher.io/blog/attributes-in-php-8)
  - [grafikart.fr/tutoriels/attribut-php8-1371](https://grafikart.fr/tutoriels/attribut-php8-1371)
- [numberOfPages](https://idpf.github.io/epub-guides/package-metadata/#schema-numberOfPages)
- spatie/laravel-medialibrary
  - [spatie.be/docs/laravel-medialibrary/v9/converting-images/optimizing-converted-images](https://spatie.be/docs/laravel-medialibrary/v9/converting-images/optimizing-converted-images)
  - [spatie.be/docs/laravel-medialibrary/v9/handling-uploads-with-media-library-pro/handling-uploads-with-vue](https://spatie.be/docs/laravel-medialibrary/v9/handling-uploads-with-media-library-pro/handling-uploads-with-vue)
  - conversions name
    - [spatie.be/docs/laravel-medialibrary/v9/advanced-usage/naming-generated-files](https://spatie.be/docs/laravel-medialibrary/v9/advanced-usage/naming-generated-files)
    - [spatie.be/docs/laravel-medialibrary/v9/converting-images/defining-conversions](https://spatie.be/docs/laravel-medialibrary/v9/converting-images/defining-conversions)
- [skeleton nuxtjs](https://stackoverflow.com/questions/57178253/how-to-create-skeleton-loading-in-nuxt-js)
- [avif format](https://www.zdnet.com/article/chrome-and-firefox-are-getting-support-for-the-new-avif-image-format/)
- jest:
  - [vue-test-utils.vuejs.org/](https://vue-test-utils.vuejs.org/)
  - [dev.to/bawa_geek/how-to-setup-jest-testing-in-nuxt-js-project-5c84](https://dev.to/bawa_geek/how-to-setup-jest-testing-in-nuxt-js-project-5c84)
  - [medium.com/@brandonaaskov/how-to-test-nuxt-stores-with-jest-9a5d55d54b28](https://medium.com/@brandonaaskov/how-to-test-nuxt-stores-with-jest-9a5d55d54b28)
  - [dev.to/alousilva/how-to-mock-nuxt-client-only-component-with-jest-47da](https://dev.to/alousilva/how-to-mock-nuxt-client-only-component-with-jest-47da)
  - [stackoverflow.com/questions/41458736/how-to-write-test-that-mocks-the-route-object-in-vue-components](https://stackoverflow.com/questions/41458736/how-to-write-test-that-mocks-the-route-object-in-vue-components)
- covers:
  - [image.nuxtjs.org](https://image.nuxtjs.org)
  - [github.com/juliomrqz/nuxt-optimized-images](https://github.com/juliomrqz/nuxt-optimized-images)

```bash
php artisan bookshelves:generate -eft
```

```bash
ln -s /home/jails/sftp/pictures-authors public/storage/raw/pictures-authors
ln -s /home/jails/sftp/pictures-series public/storage/raw/pictures-series

ln -s /home/jails/sftp/books-libres public/storage/raw/books
```

```bash
ln -s /mnt/e/WorkInProgress/ebooks/environment/books-libres public/storage/raw/books
ln -s /mnt/e/WorkInProgress/ebooks/environment/books-pirates public/storage/raw/books

ln -s /mnt/e/WorkInProgress/ebooks/environment/pictures-authors public/storage/raw/pictures-authors
ln -s /mnt/e/WorkInProgress/ebooks/environment/pictures-series public/storage/raw/pictures-series
```
