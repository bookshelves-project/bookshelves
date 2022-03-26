# Link files

```bash
New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\storage\app\public\data\books\novel\books-pirates" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\books-pirates"
```

```bash
git add storage/app/public/data/books/TYPE/.gitignore -f
```

```bash
New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\public\storage\data\books\novel\books-pirates" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\books-pirates"

New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\public\storage\data\pictures-authors\pictures-authors" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\pictures-authors"

New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\public\storage\data\pictures-series\pictures-series" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\environment\pictures-series"
```

## Windows

```bash
New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\public\storage\data\books\comic\linked" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\linked\comic"

New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\public\storage\data\books\essay\linked" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\linked\essay"

New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\public\storage\data\books\handbook\linked" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\linked\handbook"

New-Item -ItemType Junction -Path "C:\workspace\current\bookshelves-back\public\storage\data\books\novel\linked" -Target "C:\Users\ewila\OneDrive\Documents\WorkInProgress\ebooks\linked\novel"
```
