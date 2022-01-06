This is notes about concepts.

- [**tiptap**](https://www.tiptap.dev/)
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

## Commands

```bash
php artisan bookshelves:generate -eft
```

```bash
ln -s /home/jails/sftp/pictures-authors public/storage/data/pictures-authors
ln -s /home/jails/sftp/pictures-series public/storage/data/pictures-series

ln -s /home/jails/sftp/books-libres public/storage/data/books
```

```bash
ln -s /mnt/e/WorkInProgress/ebooks/environment/books-libres public/storage/data/books
ln -s /mnt/e/WorkInProgress/ebooks/environment/books-pirates public/storage/data/books

ln -s /mnt/e/WorkInProgress/ebooks/environment/pictures-authors public/storage/data/pictures-authors
ln -s /mnt/e/WorkInProgress/ebooks/environment/pictures-series public/storage/data/pictures-series

cmd /c mklink /J "C:\workspace\projets\bookshelves-back\public\storage\data\books\books-pirates" "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\books-pirates"

New-Item -ItemType Junction -Path "C:\workspace\projets\bookshelves-back\public\storage\data\books\books-pirates" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\books-pirates"

New-Item -ItemType Junction -Path "C:\workspace\projets\bookshelves-back\public\storage\data\pictures-authors\pictures-authors" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\pictures-authors"

New-Item -ItemType Junction -Path "C:\workspace\projets\bookshelves-back\public\storage\data\pictures-series\pictures-series" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\pictures-series"
```

## JsonLD

```js
// JSON LD ARTICLE

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Article",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "url"
  },
  "author": {
    "@type": "Person",
    "name": "name"
  },
  "publisher": {
    "@type": "Organization",
    "name": "publisher name",
    "logo": {
      "@type": "ImageObject",
      "url": "logo"
    }
  },
  "headline": "headline",
  "image": "image url",
  "datePublished": "2021-04-03",
  "dateModified": "2021-04-03"
}
</script>

// JSON LD WEBSITE

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "WebSite",
  "url": "url",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "search url{search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

// JSON LD PERSON

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Person",
  "name": "name",
  "image": "photo",
  "url": "website",
  "jobTitle": "job",
  "worksFor": {
    "@type": "Organization",
    "name": "company"
  }
  "sameAs": []
}
</script>

// JSON LD PRODUCT

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "name",
  "image": "image url",
  "description": "text",
  "isbn": "9782075038362",
  "brand": {
    "@type": "Brand",
    "name": "brand"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue" : "4",
    "ratingCount" : "2",
    "reviewCount" : "2",
    "worstRating" : "3",
    "bestRating" : "5"
  },
  "review": [
    {
      "@type": "Review",
      "name" : "Amazing!",
      "author": {
        "@type": "Person",
        "name": "Ewilan"
      },
      "datePublished": "2021-04-03",
      "reviewBody" : "Amazing book!",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue" : "5",
        "worstRating" : "0",
        "bestRating" : "5"
      }
    }
  ]
}

// CURRENT BOOK SLUG

jsonld() {
  const breadcrumbs = [
    {
      url: `${this.$config.baseURL}/`,
      text: 'Home',
    },
    {
      url: `${this.$config.baseURL}/books`,
      text: 'Books',
    },
    {
      url: `${this.$config.baseURL}/books/${this.$route.params.author}/${this.$route.params.slug}`,
      text: this.book.title,
    },
  ]
  const authors = this.book.authors.map((author, index) => ({
    '@type': 'Person',
    familyName: author.lastname,
    givenName: author.firstname,
    name: author.name,
    url: `${this.$config.baseURL}/authors/${author.meta.slug}`,
  }))

  const items = breadcrumbs.map((item, index) => ({
    '@type': 'BreadcrumbList',
    item: {
      '@type': 'ListItem',
      position: index + 1,
      '@id': item.url,
      name: item.text,
    },
  }))
  return {
    '@context': 'https://schema.org',
    '@type': 'WebPage',
    itemListElement: items,
    mainEntity: {
      '@type': 'Book',
      author: authors,
      bookFormat: 'http://schema.org/Book',
      datePublished: this.book.publishDate,
      image: this.book.cover.thumbnail,
      inLanguage: formatLanguage(this.book.language),
      isbn: this.book.identifier
        ? this.book.identifier.isbn || this.book.identifier.isbn13
        : null,
      name: this.book.title,
      numberOfPages: this.book.pageCount,
      publisher: this.book.publisher ? this.book.publisher.name : '',
    },
  }
},
</script>
```
