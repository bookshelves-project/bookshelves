<?php

namespace App\Providers\BookshelvesConverter;

use File;
use Storage;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Str;
use App\Utils\BookshelvesTools;
use App\Providers\ImageProvider;
use App\Providers\EbookParserEngine\EbookParserEngine;
use App\Providers\EbookParserEngine\Models\OpfCreator;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class AuthorConverter
{
    public function __construct(
        public ?string $firstname,
        public ?string $lastname,
        public ?string $role,
    ) {
    }

    public static function create(OpfCreator $creator)
    {
        $orderClassic = config('bookshelves.authors.order_firstname_lastname');

        if ($orderClassic) {
            $author_name = explode(' ', $creator->name);
            $lastname = $author_name[sizeof($author_name) - 1];
            array_pop($author_name);
            $firstname = implode(' ', $author_name);
        } else {
            $author_name = explode(' ', $creator->name);
            $firstname = $author_name[sizeof($author_name) - 1];
            array_pop($author_name);
            $lastname = implode(' ', $author_name);
        }
        $role = $creator->role;

        return new AuthorConverter($firstname, $lastname, $role);
    }

    /**
     * Generate Author[] for Book from EbookParserEngine.
     */
    public static function authors(EbookParserEngine $EPE, Book $book): Book
    {
        $authors = [];
        if (empty($EPE->creators)) {
            $creator = new OpfCreator(
                name: 'Unknown Author',
                role: 'aut'
            );
            $authorConverter = AuthorConverter::create($creator);
            $author = self::createAuthor($authorConverter, $creator);
            array_push($authors, $author);
        } else {
            foreach ($EPE->creators as $key => $creator) {
                $authorConverter = AuthorConverter::create($creator);
                $skipHomonys = config('bookshelves.authors.skip_homonyms');
                if ($skipHomonys) {
                    $lastname = Author::whereFirstname($authorConverter->lastname)->first();
                    if ($lastname) {
                        $exist = Author::whereLastname($authorConverter->firstname)->first();
                        $author = $exist;
                        array_push($authors, $author);
                    } else {
                        $author = self::createAuthor($authorConverter, $creator);
                        array_push($authors, $author);
                    }
                } else {
                    $author = self::createAuthor($authorConverter, $creator);
                    array_push($authors, $author);
                }
            }
        }
        foreach ($authors as $key => $author) {
            $book->authors()->save($author);
        }
        $book->refresh();

        return $book;
    }

    private static function createAuthor(AuthorConverter $authorConverter, object $creator)
    {
        $author = Author::firstOrCreate([
            'lastname'  => $authorConverter->lastname,
            'firstname' => $authorConverter->firstname,
            'name'      => "$authorConverter->firstname $authorConverter->lastname",
            'slug'      => Str::slug("$authorConverter->lastname $authorConverter->firstname", '-'),
            'role'      => $creator->role,
        ]);
        return $author;
    }

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
    public static function descriptionAndPicture(Author $author, bool $local, bool $default = false): Author | false
    {
        if ($author) {
            $name = $author->name;
            $name = str_replace(' ', '%20', $name);

            if (! $local) {
                $wiki = WikipediaProvider::create($author->name);
                $author = self::setLocalDescription($author);
                $author = self::setLocalNotes($author);
                if (! $author->description) {
                    $author = self::setWikipediaDescription($author, $wiki);
                }
                if (! $default) {
                    $author = self::setWikipediaPicture($author, $wiki);
                }
            } else {
                $author = self::setLocalDescription($author);
                if ($author && ! $default) {
                    self::setPicture($author);
                }
            }

            if ($author) {
                $author = $author->refresh();
            } else {
                $author = false;
            }

            return $author;
        }

        return false;
    }

    public static function setLocalDescription(Author $author): Author
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

            return $author;
        }

        return $author;
    }

    public static function setLocalNotes(Author $author): Author
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
    public static function getLocalPicture(Author $author): string | null
    {
        $disk = 'authors';

        $path = public_path("storage/raw/pictures-$disk");
        $files = MetadataExtractorTools::getDirectoryFiles($path);

        foreach ($files as $key => $file) {
            if (pathinfo($file)['filename'] === $author->slug) {
                $cover = file_get_contents($file);
                return $cover;
            }
        }

        return null;
    }

    public static function setPicture(Author $author, string $picture_file = null): Author
    {
        if (! $picture_file) {
            $picture_file = self::getLocalPicture($author);
            if (! $picture_file) {
                $picture_file = database_path('seeders/media/authors/no-picture.jpg');
                $picture_file = File::get($picture_file);
            }
        }

        $author->addMediaFromString($picture_file)
            ->setName($author->slug)
            ->setFileName($author->slug . '.' . config('bookshelves.cover_extension'))
            ->toMediaCollection('authors', 'authors');
        
        $image = $author->getFirstMediaPath('authors');
        $color = ImageProvider::simple_color_thief($image);
        $media = $author->getFirstMedia('authors');
        $media->setCustomProperty('color', $color);
        $media->save();

        return $author;
    }

    public static function setWikipediaPicture(Author $author, WikipediaProvider $wikipediaProvider, bool $debug = false): Author
    {
        try {
            $picture_file = WikipediaProvider::getPictureFile($wikipediaProvider);
            self::setPicture($author, $picture_file);
        } catch (\Throwable $th) {
            if ($debug) {
                echo "\nNo wikipedia picture_file for $wikipediaProvider->query\n";
            }
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
