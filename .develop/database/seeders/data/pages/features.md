*With Features, you can use some extra options like OPDS feed, Catalog to browse eBooks from your eReader or read an eBook in your web browser. If you are a developer, you will find Wiki for application usage, API documentation and more.*

## OPDS

>The Open Publication Distribution System (OPDS) catalog format is a syndication format for electronic publications based on Atom and HTTP. OPDS catalogs enable the aggregation, distribution, discovery, and acquisition of electronic publications. OPDS catalogs use existing or emergent open standards and conventions, with a priority on simplicity.
>
>The Open Publication Distribution System specification is prepared by an informal grouping of partners, combining Internet Archive, O'Reilly Media, Feedbooks, OLPC, and others.

APP_NAME is also available with OPDS feed, if you have any application with OPDS feature, you can add feed of APP_NAME, just add [ROUTE_OPDS_12](ROUTE_OPDS_12) to your application. To known more about application which can use OPDS, check [**More eBooks**](/pages/more-ebooks#opds). You can check [**opds.io**](https://opds.io/) to know more about OPDS, APP_NAME OPDS is based on [**specs.opds.io**](https://specs.opds.io/).

### Versions

OPDS versions available

- v1.2: [ROUTE_OPDS_12](ROUTE_OPDS_12)

## Catalog

Most of eReader can't read OPDS feeds, so to download directly eBooks you have to use a computer and set manually eBooks on your device, etc... But **Catalog** is the solution **to download directly eBooks on your eReader without any computer**.

If you have any eReader with browser, you can use **Catalog**, it's an very simple interface for your eReader like any shop to directly search and download eBooks. You have just to put [ROUTE_CATALOG](ROUTE_CATALOG) URL into your eReader browser. To know more about download of eBooks with browser from your eReader, check [**Download eBook from eReader guide**](/guides/ereader-download-ebook-from-ereader).

### Limitations

- you will **not be able to have the series associated with an eBook** with this method because of the limitations of the EPUB format used. The only solution\* is to add the series with the Calibre software, as explained in this guide [**Get series on your Kobo**](/guides/ereader-series) for Kobo eReaders, with a file added on your eReader.
- you will **not be able to download a whole series or all the eBooks of an author** because it is a .zip format that is proposed and your eReader only reads the formats linked to the eBooks.

### Why ?

The eReader's web browser is not very powerful, it's can be difficult to use because the touch on an eReader is not very responsive. Therefore, the OPDS adapts to this difficulty and proposes to search directly for the desired eBook, series or author in order to limit the results and to find the eReader more easily.

## Webreader

You can read any eBook available on APP_NAME **directly in your browser with Webreader**, you can **access it from the detail page of any book** in the available actions. Webreader is a simple and effective feature aimed at allowing you to quickly read an eBook but not having all the options like on an eReader. You can **discover Webreader right now** by trying it with a random eBook from [ROUTE_WEBREADER](ROUTE_WEBREADER).

*: You may have noticed that the store allows you to display the series of the books you add from it but this is because as an internal program of your eReader, the store can modify the information related to an eBook and thus add the series, which Calibre can do more manually.
