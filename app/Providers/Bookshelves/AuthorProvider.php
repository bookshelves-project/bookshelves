<?php

namespace App\Providers\Bookshelves;

use File;
use Http;
use Storage;
use App\Models\Author;
use App\Utils\BookshelvesTools;
use App\Providers\ImageProvider;
use App\Providers\WikipediaProvider;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class AuthorProvider
{
    /**
     * Generate Author image & description.
     *
     * Generate description:
     * - from Wikipedia if found.
     *
     * Generate image:
     * - from `public/storage/raw/pictures-authors` if JPG file with author slug name exists
     * - from Wikipedia if found, managed by `spatie/laravel-medialibrary`
     * - if not use default image `database/seeders/media/authors/no-picture.jpg`
     */
    public static function descriptionAndPicture(Author $author, bool $alone, bool $no_cover): Author
    {
        $name = $author->name;
        $name = str_replace(' ', '%20', $name);

        if (! $alone) {
            $wiki = WikipediaProvider::create($author->name);
            $result = self::setLocalDescription($author);
            $author = self::setLocalNotes($author);
            if (! $result) {
                $author = self::setWikipediaDescription($author, $wiki);
            }
            if (! $no_cover) {
                $author = self::setWikipediaPicture($author, $wiki);
            }
        } else {
            $author = self::setLocalDescription($author);
            if (! $no_cover) {
                $author = self::setLocalPicture($author);
            }
        }

        $author = $author->refresh();

        return $author;
    }

    public static function setLocalDescription(Author $author): Author | null
    {
        if (File::exists(public_path('storage/raw/authors.json'))) {
            $json = Storage::disk('public')->get('raw/authors.json');
            $json = json_decode($json);
            foreach ($json as $key => $value) {
                if ($key === $author->slug) {
                    $author->description = $value->description ?? null;
                    $author->link = $value->link ?? null;
                    $author->save();

                    return $author;
                }
            }

            return null;
        }

        return null;
    }

    public static function setLocalNotes(Author $author): Author | null
    {
        if (File::exists(public_path('storage/raw/authors-notes.json'))) {
            $json = Storage::disk('public')->get('raw/authors.json');
            $json = json_decode($json);
            foreach ($json as $key => $value) {
                if ($key === $author->slug) {
                    $author->note = $value->note ?? null;
                    $author->save();

                    return $author;
                }
            }

            return $author;
        }

        return $author;
    }

    public static function setWikipediaDescription(Author $author, WikipediaProvider $wikipediaProvider): Author
    {
        $extract = BookshelvesTools::stringLimit($wikipediaProvider->extract, 1000);

        $author->description = $extract;
        $author->link = $wikipediaProvider->page_url;
        $author->save();

        return $author;
    }

    /**
     * Get local picture from `public/storage/raw/pictures-authors`
     * Only JPG file with author slug as name.
     */
    public static function setLocalPicture(Author $author): Author
    {
        $disk = 'authors';
        $custom_authors_path = public_path("storage/raw/pictures-$disk/$author->slug.jpg");

        if (File::exists($custom_authors_path)) {
            $file_path = File::get($custom_authors_path);
            $author->addMediaFromString($file_path)
                ->setName($author->slug)
                ->setFileName($author->slug.'.'.config('bookshelves.cover_extension'))
                ->toMediaCollection($disk, $disk);
            $author->save();
        }

        return $author;
    }

    public static function setWikipediaPicture(Author $author, WikipediaProvider $wikipediaProvider): Author
    {
        try {
            $picture_file = WikipediaProvider::getPictureFile($wikipediaProvider);
            if (! $picture_file) {
                $picture_file = database_path('seeders/media/authors/no-picture.jpg');
                $picture_file = File::get($picture_file);
            }
            
            $author->addMediaFromString($picture_file)
                ->setName($author->slug)
                ->setFileName($author->slug.'.'.config('bookshelves.cover_extension'))
                ->toMediaCollection('authors', 'authors');
            
            $image = $author->getFirstMediaPath('authors');
            $color = ImageProvider::simple_color_thief($image);
            $media = $author->getFirstMedia('authors');
            $media->setCustomProperty('color', $color);
            $media->save();
        } catch (\Throwable $th) {
            echo "\nNo wikipedia picture_file for $wikipediaProvider->query\n";
        }

        return $author;
    }

    /**
     * Generate Author tags from Books relationship tags.
     */
    public static function tags(Author $author): Author
    {
        $books = $author->books;
        $tags = [];
        foreach ($books as $key => $book) {
            foreach ($book->tags as $key => $tag) {
                array_push($tags, $tag);
            }
        }

        $author->syncTags($tags);
        $author->save();

        return $author;
    }
}
