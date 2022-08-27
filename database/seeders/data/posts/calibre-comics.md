Manage your own comics and mangas with Calibre isn't so easy, you need to have some informations about these specifics formats.

**Required**

- [**Calibre**](https://calibre-ebook.com): to manage your comics and mangas
- [**7zip**](https://www.7-zip.org): to create ZIP formats

## About CBZ

An eBook can use many formats like EPUB, AZW, MOBI, etc... If we want to use only open-source and drm-free formats, we will choose a format like EPUB. But about comics and mangas, we have some different formats like CBZ or CBR, for example, for *Comic Book Archive file*. Here we will use only CBZ because is a very common format created from ZIP file rename to CBZ.

```[my-comic.cbz]
|-- my-comic
    |-- img01.jpg
    |-- img02.jpg
    |-- ...
|-- ComicInfo.xml
```

```xml[my-comic/ComicInfo.xml]
<?xml version="1.0"?>
<ComicInfo xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <Title>Castel Or-Azur</Title>
  <Series>Lanfeust de Troy</Series>
  <Number>3.0</Number>
  <Writer>Didier Tarquin, Christophe Arleston</Writer>
  <Publisher>Soleil</Publisher>
  <LanguageISO>fr</LanguageISO>
</ComicInfo>
```

- install plugin: [**EmbedComicMetadata**](https://github.com/dickloraine/EmbedComicMetadata)
- configure plugin
- metadata, standards
- post for [**epub formats**](https://en.wikipedia.org/wiki/Comparison_of_e-book_formats)
