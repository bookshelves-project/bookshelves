---
title: Help
subtitle: Help for Bookshelves
description: How to use Bookshelves
---

## Download

On Bookshelves, you can download books, comics and audiobooks. If you encounter an error, if you don't understand any aspect of the platform or if you have any suggestions, don't hesitate to use the [contact form](/form/message).

## How to read eBooks, comics and audiobooks?

Bookshelves files use `.epub` format for eBooks, `.cbz` for comics and `.m4b` for audiobooks. You can read these files with different softwares.

### `.epub` extension

> EPUB is an e-book file format that uses the ".epub" file extension. The term is short for electronic publication and is sometimes stylized as ePub. EPUB is supported by many e-readers, and compatible software is available for most smartphones, tablets, and computers.

-   eReader
    -   [koreader/koreader](https://github.com/koreader/koreader): An ebook reader application supporting PDF, DjVu, EPUB, FB2 and many more formats, running on Kindle, Kobo, PocketBook, Ubuntu Touch and Android devices.
-   Desktop
    -   [edrlab/thorium-reader](https://github.com/edrlab/thorium-reader): A cross-platform desktop ebook reader.
    -   [koodo-reader/koodo-reader](https://github.com/koodo-reader/koodo-reader): A simple ebook reader for desktop built with Vue.js and Electron.
-   Android
    -   [ReadEra](https://play.google.com/store/apps/details?id=org.readera)

### `.cbz` extension

> A file with .cbz extension is a comic book ZIP archive file that is a collection of images, representing the pages of a comic book. CBZ is different from other ebook files that are not compressed. Most of the ebook and comic book readers support viewing these files.

> If you want to handle metadata for Comics on [Calibre](https://calibre-ebook.com/), you can use [EmbedComicMetadata](https://www.mobileread.com/forums/showthread.php?t=264710) plugin.

-   Desktop
    -   [yacreader](https://www.yacreader.com/downloads): YACReader is a cross-platform comic reader developed using Qt4 with support for multiple comic files and image formats. YACReader comes with YACReaderLibrary, an application for browsing and managing your comic collections with various smooth transition effects.
-   Android
    -   [Perfect Viewer](https://play.google.com/store/apps/details?id=com.rookiestudio.perfectviewer): Perfect Viewer is a very fast image/comic viewer (no ads) that supports CBZ/ZIP, CBR/RAR, 7Z/CB7, LZH, CBT/TAR, PDF, and EPUB formats.
    -   [ComicScreen](https://play.google.com/store/apps/details?id=com.viewer.comicscreen)
    -   [CDisplayEx](https://play.google.com/store/apps/details?id=com.progdigy.cdisplay.free)

### `.m4b` extension

> .m4b is the file extension for MPEG-4 files, commonly used for audio books. It can be read by any media player or audio book player with the ability to open these type of files and is a common file type for audio books downloaded from iTunes or Audible.

-   Desktop
    -   [VLC](https://www.videolan.org/) (any OS)
    -   [IINA](https://iina.io/) (macOS)
-   Android
    -   [Smart AudioBook Player](https://play.google.com/store/apps/details?id=ak.alizandro.smartaudiobookplayer): The app is designed specially for playing audio books. Assumed that you have audiobooks and already copied them to your phone.
    -   [Pulsar Music Player](https://play.google.com/store/apps/details?id=com.rhmsoft.pulsar): Pulsar is intuitive, lightweight and full featured music player for Android, you can use it as an audiobook player.
-   Server
    -   [audiobookshelf](https://github.com/advplyr/audiobookshelf): if you want to host your own audiobook server, audiobookshelf is a self-hosted audiobook and podcast server

### What about DRM?

All books, comics and audiobooks on Bookshelves are DRM-free. You can read more about DRM on [Wikipedia](https://en.wikipedia.org/wiki/Digital_rights_management).

## OPDS

Official website: [opds.io](https://opds.io/)

OPDS is like RSS feeds but adapted for eBooks, it's a standard to share eBooks between libraries, bookstores, publishers, and readers. Developed by Hadrien Gardeur and Leonard Richardson.

_The Open Publication Distribution System (OPDS) catalog format is a syndication format for electronic publications based on Atom and HTTP. OPDS catalogs enable the aggregation, distribution, discovery, and acquisition of electronic publications. OPDS catalogs use existing or emergent open standards and conventions, with a priority on simplicity. The Open Publication Distribution System specification is prepared by an informal grouping of partners, combining Internet Archive, O'Reilly Media, Feedbooks, OLPC, and others._

Bookshelves offers an OPDS feed **for eBooks only**, audiobooks and comics are not supported, powered by [kiwilan/php-opds](https://github.com/kiwilan/php-opds).

To read the OPDS feed, you can use different softwares:

-   [koreader/koreader](https://github.com/koreader/koreader): An ebook reader application supporting PDF, DjVu, EPUB, FB2 and many more formats, running on Kindle, Kobo, PocketBook, Ubuntu Touch and Android devices.
-   [edrlab/thorium-reader](https://github.com/edrlab/thorium-reader): A cross-platform desktop ebook reader.

## Calibre

Official website: [calibre-ebook.com](https://calibre-ebook.com/)

Calibre is a free and open-source e-book manager. It can view, convert and catalog e-books in most of the major e-book formats. It can also talk to many e-book reader devices. It can go out to the Internet and fetch metadata for your books. It can download newspapers and convert them into e-books for convenient reading. It is cross-platform, running on Linux, Windows and macOS.

You can use Calibre to manage your library, convert eBooks to other formats, edit metadata, etc.
