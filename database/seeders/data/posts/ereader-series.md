This article was written using a Kobo as eReader.

**Required**

- [**Calibre**](https://calibre-ebook.com): to manage your comics and mangas

## Review

For a series of eBooks, you can have a **series** feature, if the series is set your eReader could not display it. If you want short guide, check this, otherwise you can read all article.

- Connect your eReader to your computer 🔌
- Add EPUB files to your eReader (with Calibre or manually) 📁
- Disconnect and wait importation by your eReader ⏏️
- Check if books are present 📚
- Connect **again** your eReader to your computer 🔌
- Open Calibre 📚
- Click on **Device** in Calibre and execute *Update cached metadata on device* 👩‍💻
- Disconnect your eReader after seconds ⏏️
- Check in **My books**, in *Series* tab if series appear 📖

---

## About series

On APP_NAME, many EPUB files have **series** *metadata* to display book series and series number. If you transfer directly EPUB files from APP_NAME on your eReader or if you use Calibre (or other software to format EPUB files) to set series, you can have some problem to display your eBooks by series on your eReader.

- With a eReader you can transfer manually EPUB files to your eReader with USB cable from your computer, if you transfer EPUB files like this, you can find your eBooks on your eReader but series won't work because *metadata* of eReader have to be refreshed.
- With eBooks from eReader shop you can download eBooks with **sync** and series will work because sync update *metadata* for eBooks from eReader shop.

If you want to refresh *metadata* for eBooks manually transfered, you will need to use Calibre software (you can transfer manually EPUB files but you will have to execute an option on Calibre), so if you haven't, [**download and install Calibre**](https://calibre-ebook.com).

![An example of EPUB file with series and number on Calibre](IMAGE/ereader-series/calibre-serie.webp)

### Refresh *metadata*

Now you can transfer manually any eBooks which have a series, transfer all the series on your eReader with USB cable.

![Here an example with **L'Autre**, a books series of Pierre Bottero transfered to my eReader](IMAGE/ereader-series/books-list.webp)

When EPUB are on your eReader, you can **safely** disconnect it. Wait seconds to let eReader to import new content and when it's done and you can see new books, you will see in **My books**, on tab *Series*, you will **not see** the series. It's because eReader haven't refresh *metadata*, to refresh this, you need to connect again your eReader to your computer and open Calibre.

![Click on Device from toolbar](IMAGE/ereader-series/calibre.webp)

And you will see **Device** entry on Calibre, and you can execute **Update cached metadata on device**, this option will refresh *metadata* and now you can safely disconnect your eReader from your computer and you will see the series in *Series* tab in **My books**.

![Select Update cached metadata on device](IMAGE/ereader-series/calibre-options.webp)

You will have to do this **each time** you add a new series to your eReader.

![An example of series on Kobo](IMAGE/ereader-series/kobo-series.webp)

---

## Why series have this problem?

EPUB files use metadata to display informations about their content: title, authors, cover, description, publisher, language... But these metadata respect a guide wrote by W3C, here you can find [EPUB 3 Metadata guide](https://www.w3.org/publishing/epub3/epub-packages.html) but many eBooks use EPUB 2 system today\*¹. In this guide, you can see `series` not exist (except for `collection` but not like a real have to be with title and volume number). Calibre found a solution: create new custom metadata out of W3C guide, so Calibre can read it to display eBooks by series but not eReaders.

To display correctly series on your eReader, Calibre have to list all ebooks which use custom series metadata and update database of your eReader to add series data to allow eReader to display these informations. For example, if you have a eReader eReader and you buy an eBook on store with a series information, when eBook will be downloaded on your eReader, store will update your eReader database too to display series.

Today, there is not magic solution about this problem but Calibre offer a simple solution. If you want to know more about EPUB metadata, you can check [**Dublin Core Metadata initiative**](https://www.dublincore.org/specifications/dublin-core/dcmi-terms).

\*¹: today most eReader can't read EPUB 3, so EPUB 2 is the common format for lot of EPUB, to know what differences exists, you can check [W3C guide](https://www.w3.org/AudioVideo/ebook)
