You need to install [**Calibre**](https://calibre-ebook.com) to follow this guide. This software is available on Windows, MacOS and Linux. An EPUB file is just an archive like ZIP, you can open it with [**7zip**](https://www.7-zip.org), you will see that all EPUBs are far from being the same, some have been well designed and others have the files in bulk (even if they will work). One file is important `content.opf`, in this file you can find all metadata. It's this file you can easily edit with Calibre, you can try to edit it manually but it's not really easy because it's XML file not user friendly.

**Required**

- [**Calibre**](https://calibre-ebook.com): to manage your comics and mangas

## Technical words

In this guide, I use some words from eBook world.

- **Kobo** : brand of eReader to read eBooks like EPUB files
- **eBook**: numeric book, we can find many different format like EPUB or MOBI
- **EPUB**: format for an eBook, it's generally DRM\*¹-free\*²

In this guide, I will talk about eBooks with EPUB formats, Calibre can display eBooks with multiple formats, you can convert MOBI to EPUB or many other formats. With Calibre you can manage multiple eReaders, my eReader is a Kobo, so I talk about Kobo.

## What is metadata?

On an e-book, the metadata represents the identity of the book. It's the title, the author and the cover of course, but you can add the name of the series, the serial number, the publisher, the date of publication, the tags, the comments, the ISBN... You can read an eBook without any metadata on your Kobo but to find a book, it is better to have a title, an author and a cover. You may think that other metadata is not really important... and if you don't have too many eBooks, it's true. You need metadata when you have a large collection of eBooks so you can easily search and browse books.

On a physical book, you have all this information but an eBook only has the information provided by yourself or by the store where you bought your eBook (and stores don't always put valid metadata). We can find several interesting metadata but here is a list of the most needed according to your needs:

- `title`
- `author`
- `cover` very useful to recognize an eBook
- `series` if you have an eBook from a series like `The Hunger Games` with *The Hunger Games*, *Catching Fire*, *Mockingjay* and *The Ballad of Songbirds and Snakes*
- `number` to indicate volume number in a series like `2,00` for *Catching Fire* in *The Hunger Games* series
- `ids` to indicate some *ids* for eBook, the most important is ISBN\*³ like *9780545227247* for *Catching Fire* (to add *ids*, you need to indicate reference before like `isbn:9780545227247`)
- `languages` useful if you have translations

## Add EPUB to Calibre

When Calibre is installed, launch it and you will have an interface with just one eBook, the starter guide. You can **add new eBooks with drag and drop** or **with add books button**.

![Calibre interface is not really beautiful but very complete.](IMAGE/calibre-metadata/calibre-interface.webp)

To edit metadata, click right on an eBook and select **Edit metadata** and you can update individually.

![Edit metadata of eBook](IMAGE/calibre-metadata/calibre-edit-one.webp)

**Warning** : you can update multiple eBooks with **bulk edit** but pay attention of modifications, it's useful to update **series** or **publisher** but you can override existant data.

## Manually update metadata

We take an example [**La Forêt des captifs**](https://books.google.fr/books/about/La_for%C3%AAt_des_captifs.html?id=aaTpq7gPs-8C&redir_esc=y) by Pierre Bottero, volume 01 of Les Mondes d'Ewilan in french.

- Title: `La Forêt des captifs`
- Author: `Pierre Bottero`, *firstname lastname* or reverse just keep same pattern for all books
- Series: `Les Mondes d'Ewilan`
- Number: `1,00`

![You can clik on the arrow à the right of title and author to improve sorting, useful just for Calibre](IMAGE/calibre-metadata/calibre-meta-title.webp)

- Cover: you can delete current cover and add a new from your files, I advice `480x770` (ratio 1.6:1) in `.webp` or `.jpg`. If you haven't cover, you can download it from API with **Download cover** but it will be big size cover and EPUB file will be heavy.

![You can clik on the arrow à the right of title and author to improve sorting, useful just for Calibre](IMAGE/calibre-metadata/calibre-meta-cover.webp)

- Ids: `isbn:9782700239904` search ISBN 13, you can find it on Google Books or Wikipedia
- Published: `21 février 2007` (select day to valid date)
- Publisher: `Rageot`
- Languages: `Français`

![For `Ids` you have to specify type.](IMAGE/calibre-metadata/calibre-meta-misc.webp)

- Comments: `Tandis que ses parents explorent des territoires sauvages de l'autre monde, Ewilan...`

![You can use HTML for comments but it's not a good idea.](IMAGE/calibre-metadata/calibre-meta-comment.webp)

## Automatically update metadata

We have seen how to put metadata for a single book by hand. It's each time about 5 minutes to search for information according to the level of detail you want, retrieve a cover and rework it if necessary, etc... It is possible to automatically retrieve metadata and cover about the current book by using in the publicly available APIs. You can try it with **Download metadata**.

![Try to download metadata from Internet.](IMAGE/calibre-metadata/calibre-meta-auto.webp)

It will take some time but it's really useful to full metadata. **But** information may not be exactly right, you will have to check it and the proposed coverage is often in high definition and therefore quite heavy, prefer a coverage resized by yourself if the size of the EPUB file matters to you.

And now you can edit bulk eBooks with **Edit metadata**->**Download metadata and covers** to download metadata for multiple eBooks.

![Download meta from eBooks list.](IMAGE/calibre-metadata/calibre-meta-misc.webp)

### Bulk conversion

When you update metadata or edit books, don't hesitate to execute a bulk book conversion to generate again an EPUB files for multiple eBooks to be sure to update informations in each eBook, of course you can find generated file with **Open  containing folder**.

![With bulk convert, you can select all your library to convert all eBooks.](IMAGE/calibre-metadata/calibre-convert-bulk.webp)

When conversion is finish, you can get EPUB files from Calibre directory or just connect your Kobo to your computer and Calibre will detect it automatically and you will be able to transfer eBooks from Calibre, don't hesitate to check [**Series on Kobo**](ereader-series) to know how to display **series** on Kobo.

## About EPUB size

The metadata adds very little to the final weight of the EPUB file except for the cover. That's why you have to pay attention to the image that will be used to generate the cover. If it is important to have a quality cover for a physical book, an eBook doesn't need a very high quality cover `480x770` (1.6:1 ratio) may be more than enough with the WEBP format of preference (even if Calibre will convert this file).

Paying attention to this kind of detail is important for the final weight of the book which can easily go from 1.5 MB to 400 KB depending on the images used (like the cover but also the images present in the book). It may seem unimportant, your Kobo can store a lot of eBooks even if they are quite heavy. The problem is simply that the more eBooks you accumulate, the more space they take up, and the heavier an eBook is, the longer it will take your Kobo to open it. Select **Edit book** to check all files into EPUB archive with size.

![Edit an eBook is very useful to remove large assets like images and fonts.](IMAGE/calibre-metadata/calibre-edit-book.webp)

You can update files here but you have to delete original copy (ORIGINAL_EPUB file) of EPUB made by Calibre otherwise original copy will override your changements. Select **Open  containing folder** if you want to find where Calibre keep files for a book.

### Conversion

When you update metadata or edit book, don't hesitate to execute a book conversion to generate again an EPUB file to be sure to update informations in eBook, of course you can find generated file with **Open  containing folder**.

![Convert eBook when you update meta to erase old meta.](IMAGE/calibre-metadata/calibre-convert.webp)

---

\*¹: Digital Right Management  
\*²: when you buy the EPUB file you can do anything with it like share it to your family  
\*³: *International Standard Book Number*  

[**About ISBN**](https://www.afnil.org/autre-media) (french article)

Today, we can find ISBN 10 which is old ISBN, and now we use ISBN 13. With ISBN we can retrieve book in some databases, like **9782700239904** for **La Forêt des captifs** by *Pierre Bottero*. If we search in Google [**La Forêt des captifs book**](https://www.google.fr/search?tbm=bks&hl=fr&q=La+for%C3%AAt+des+captifs), we can find some books and I select [**this one**](https://books.google.fr/books?id=aaTpq7gPs-8C&dq=La+for%C3%AAt+des+captifs&hl=fr&source=gbs_navlinks_s). And with ISBN, we can use Google Books API like this [**Google Books API for 9782700239904**](https://www.googleapis.com/books/v1/volumes?q=isbn:9782700239904).
