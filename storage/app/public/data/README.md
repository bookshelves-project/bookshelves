# Link files

## Linux

```bash
sudo ln -s /Users/ewilan/Documents/WorkInProgress/ebooks/linked/comic public/storage/data/books/comic/linked

sudo ln -s /Users/ewilan/Documents/WorkInProgress/ebooks/linked/essay public/storage/data/books/essay/linked

sudo ln -s /Users/ewilan/Documents/WorkInProgress/ebooks/linked/handbook public/storage/data/books/handbook/linked

sudo ln -s /Users/ewilan/Documents/WorkInProgress/ebooks/linked/novel public/storage/data/books/novel/linked

sudo ln -s /Users/ewilan/Documents/WorkInProgress/ebooks/linked/pictures-authors public/storage/data/authors/pictures

sudo ln -s /Users/ewilan/Documents/WorkInProgress/ebooks/linked/pictures-series public/storage/data/series/pictures
```

## Windows

```bash
New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\audio\linked" -Target "C:\Users\ewila\wip\ebooks\linked\audio"

New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\comic\linked" -Target "C:\Users\ewila\wip\ebooks\linked\comic"

New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\essay\linked" -Target "C:\Users\ewila\wip\ebooks\linked\essay"

New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\handbook\linked" -Target "C:\Users\ewila\wip\ebooks\linked\handbook"

New-Item -ItemType Junction -Path "C:\workspace\bookshelves-back\public\storage\data\books\novel\linked" -Target "C:\Users\ewila\wip\ebooks\linked\novel"
```
