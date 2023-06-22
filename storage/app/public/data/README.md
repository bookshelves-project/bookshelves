# Commands

## Linux

### Set Books path

```bash
rm public/storage/data/books/audio/linked
rm public/storage/data/books/comic/linked
rm public/storage/data/books/novel/linked
sudo ln -s /Users/ewilan/Documents/books/storage/output/audio public/storage/data/books/audio/linked
sudo ln -s /Users/ewilan/Documents/books/storage/output/comics public/storage/data/books/comic/linked
sudo ln -s /Users/ewilan/Documents/books/storage/output/novels public/storage/data/books/novel/linked
```

### Set Authors and series path

```bash
sudo ln -s /Users/ewilan/Documents/books/linked/pictures-authors public/storage/data/authors/pictures
sudo ln -s /Users/ewilan/Documents/books/linked/pictures-series public/storage/data/series/pictures
```

## Windows

### Set Books path

```ps1
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\audio\linked" -Target "C:\Users\ewila\wip\ebooks\linked\audio"
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\comic\linked" -Target "C:\Users\ewila\wip\ebooks\linked\comic"
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\essay\linked" -Target "C:\Users\ewila\wip\ebooks\linked\essay"
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\handbook\linked" -Target "C:\Users\ewila\wip\ebooks\linked\handbook"
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\novel\linked" -Target "C:\Users\ewila\wip\ebooks\linked\novel"
```

### Set Authors and series path

```ps1
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\authors\pictures" -Target "C:\Users\ewila\wip\ebooks\linked\pictures-authors"
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\series\pictures" -Target "C:\Users\ewila\wip\ebooks\linked\pictures-series"
```
