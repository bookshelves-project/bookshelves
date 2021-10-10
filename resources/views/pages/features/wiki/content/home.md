This Wiki is about Bookshelves project, you will find two parts covered here: the back-end part made in Laravel
which is clearly the most important part in Bookshelves and the front-end part in NuxtJS which retrieves data from
the API in order to display it in a nice user interface.

If you are interested in Bookshelves, you can keep only the back-end part and create your own front-end with the
technology you want. All the logic of Bookshelves is in the backend and it is even possible to not use an external
frontend and use Bookshelves with the internal backend interface.

## Concept

The goal of Bookshelves is to create a database from a list of eBooks that are analyzed by the back-end with Laravel (PHP). All the metadata of each eBook are extracted and processed to create each book with its relationships: **authors**, **publisher**, **date of release**, **language**, **identifiers**, **tags**, **description**, **cover** and **serie**.

- The **identifiers** allow ISBN, ISBN13, DOI, Amazon, Google.
- The **series** and **volume** are also retrieved if they are present according to the system created by **Calibre**, this information not being listed by the EPUB format.
- The **tags** are separated into *tags* and *genres* to create main and secondary tags, the genres are taken from [Wikipedia](https://en.wikipedia.org/wiki/List_of_writing_genres).

From these relations, all the books of the same series can be listed but also the books and series close by tag. It is interesting to note that a book can have several authors even if only one "main" author is considered for URL generation. Of course, with such a system if the eBooks have a single error on important data, this can have unexpected consequences. With **ParserEngine**, only **title** is *not nullable*, if any other data is null, the engine will set a default value if necessary:

- If eBook doesn't have an author, default author will be `Unkown Author`
- If eBook doesn't have a language, default language will be `unknown`

**The back-end can work without the front-end by using only Catalog as an interface**

- Generation of eBooks with additional data generation with GoogleBooks and Wikipedia API
  - eBooks : number of pages
  - Authors: description, URL link, photo
  - Series: description, link
  - Each information can be overridden with JSON files presenting the data or JPG files for the pictures
- Generation of an API with documentation
- Wiki with a documentation for installation and use
- An OPDS (Open Publication Distribution System) feed
- An interface called Catalog presenting the data in a very simplified way in order to allow access from the browser of an eReader and thus to download eBooks with an integrated search
- An eBook reader in the browser, WebReader, in order to consult directly an eBook

**The front-end offers a more modern interface by providing**

- More data for each entry
- An advanced search
- A pagination on the data in collection
- The download of eBooks but also of all the books of a specific author or series as a ZIP file.
- A commenting and bookmarking system for logged-in users.
- Retrieval of additional data: publishers, tags, genres and associated eBooks & series
- Guides to inform users on how to use an eReader or eBooks
- Dark mode
- Contact form

### *Common mistakes*

#### Example with Language

let's take the language of an English eBook that is mistakenly indicated as French and that is part of a "D'Artagan Romances" series, then this eBook will be part of its own specific series "D'Artagan Romances" indicated as French while the others will be part of the "D'Artagan Romances" series indicated as English. This allows to have two series with the same name in several languages but requires a precise work in setting up the metadata with Calibre for example.

> - URL of Serie for The Three Musketeers from Alexandre Dumas in french: `/dumas-alexandre/d-artagnan-romances-fr`
> - URL for SErie for Twenty Years After from Alexandre Dumas in english: `/dumas-alexandre/d-artagnan-romances-en`

#### Example with Author

an eBook "The Three Musketeers" has a lastname-firstname author name such as "Alexandre Dumas" while another eBook of the same series "Twenty Years After" has a lastname-firstname author name such as "Dumas Alexandre". During the generation, two different authors will be created and thus two different series, so all the eBooks must have the name of each author indicated in the same way, the proposal of Bookshelves is to prefer firstname-lastname. It's important because with this order, Bookshelves can seperate firstname and lastname to order authors. **You can reverse firstname-lastname into config/bookshelves.php**

> - The Three Musketeers from Alexandre Dumas: `/dumas-alexandre/three-musketeers-en` from serie `/dumas-alexandre/d-artagnan-romances-en`
> - Twenty Years After from Dumas Alexandre: `/alexandre-dumas/twenty-years-after-en` from serie `/alexandre-dumas/d-artagnan-romances-en`

### *What Bookshelves is not*

Bookshelves is not like Calibre with dynamic database from EPUB into a specific directory, with Bookshelves you have to parse all EPUB in a directory and, if you add another, you have to parse for new EPUB (fastly than first parse) to generate new eBooks for database. You can use this application like Calibre but it's not same. If you want a Calibre app for web, check these projects:

- [**github.com/janeczku/calibre-web**](https://github.com/janeczku/calibre-web)
- [**github.com/seblucas/cops**](https://github.com/seblucas/cops)

## Links

🚀 [**bookshelves.ink**](https://bookshelves.ink): demo of Bookshelves  

### *Features*

🔒 [**bookshelves.ink/admin**](https://bookshelves.ink/admin): admin of Bookshelves usage  
📔 [**bookshelves.ink/wiki**](https://bookshelves.ink/wiki): wiki for Bookshelves usage  
👩‍💻 [**bookshelves.ink/docs**](https://bookshelves.ink/docs): API documentation  
🔖 [**bookshelves.ink/opds**](https://bookshelves.ink/opds): OPDS feed for applications which can read this feed  
📚 [**bookshelves.ink/catalog**](https://bookshelves.ink/catalog): Catalog, a basic interface for eReader browser to download eBook from eReader  
📖 [**bookshelves.ink/webreader**](https://bookshelves.ink/webreader): Webreader, to read any Bookshelves eBook into your browser  

### *Repository*

📀 [**gitlab.com/ewilan-riviere/bookshelves-back**](https://gitlab.com/ewilan-riviere/bookshelves-back) : back-end of Bookshelves  
🎨 [**gitlab.com/ewilan-riviere/bookshelves-front**](https://gitlab.com/ewilan-riviere/bookshelves-front) : front-end of Bookshelves  
