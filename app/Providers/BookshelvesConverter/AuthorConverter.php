<?php

namespace App\Providers\BookshelvesConverter;

use File;
use Storage;
use App\Models\Book;
use App\Models\Author;
use App\Utils\MediaTools;
use Illuminate\Support\Str;
use App\Utils\BookshelvesTools;
use App\Providers\WikipediaProvider;
use App\Providers\EbookParserEngine\EbookParserEngine;
use App\Providers\EbookParserEngine\Models\OpfCreator;

class AuthorConverter
{
    public function __construct(
        public ?string $firstname,
        public ?string $lastname,
        public ?string $role,
    ) {
    }

    /**
     * Convert OpfCreator to AuthorConverter from config order
     *
     * @param OpfCreator $creator
     *
     * @return AuthorConverter
     */
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
     * Create Author if not exist
     *
     * @return Author
     */
    private static function convert(AuthorConverter $converter, object $creator)
    {
        $author = Author::firstOrCreate([
            'lastname'  => $converter->lastname,
            'firstname' => $converter->firstname,
            'name'      => "$converter->firstname $converter->lastname",
            'slug'      => Str::slug("$converter->lastname $converter->firstname", '-'),
            'role'      => $creator->role,
        ]);
        return $author;
    }

    /**
     * Generate Author[] for Book from EbookParserEngine.
     */
    public static function generate(EbookParserEngine $EPE, Book $book): Book
    {
        $authors = [];
        if (empty($EPE->creators)) {
            $creator = new OpfCreator(
                name: 'Unknown Author',
                role: 'aut'
            );
            $converter = AuthorConverter::create($creator);
            $author = AuthorConverter::convert($converter, $creator);
            array_push($authors, $author);
        } else {
            foreach ($EPE->creators as $key => $creator) {
                $converter = AuthorConverter::create($creator);
                $skipHomonys = config('bookshelves.authors.skip_homonyms');
                if ($skipHomonys) {
                    $lastname = Author::whereFirstname($converter->lastname)->first();
                    if ($lastname) {
                        $exist = Author::whereLastname($converter->firstname)->first();
                        $author = $exist;
                        array_push($authors, $author);
                    } else {
                        $author = AuthorConverter::convert($converter, $creator);
                        array_push($authors, $author);
                    }
                } else {
                    $author = AuthorConverter::convert($converter, $creator);
                    array_push($authors, $author);
                }
            }
        }
        foreach ($authors as $key => $author) {
            $book->authors()->save($author);
            AuthorConverter::tags($author);
        }
        $book->refresh();

        return $book;
    }

    /**
     * Generate Author image & description.
     *
     * Generate description:
     * - from Wikipedia if found.
     *
     * Generate image:
     * - from `public/storage/data/pictures-authors` if JPG file with author slug name exists
     * - from Wikipedia if found, managed by `spatie/laravel-medialibrary`
     * - if not use default image `database/seeders/media/authors/no-picture.jpg`
     */
    // public static function descriptionAndPicture(Author $author, bool $local, bool $default = false): Author | false
    // {
    //     if ($author) {
    //         $name = $author->name;
    //         $name = str_replace(' ', '%20', $name);

    //         if (! $local) {
    //             $wiki = WikipediaProvider::create($author->name);
    //             $author = self::setLocalDescription($author);
    //             $author = self::setLocalNotes($author);
    //             if (! $author->description) {
    //                 $author = self::setWikipediaDescription($author, $wiki);
    //             }
    //             if (! $default) {
    //                 $author = self::setWikipediaPicture($author, $wiki);
    //             }
    //         } else {
    //             $author = self::setLocalDescription($author);
    //             if ($author && ! $default) {
    //                 self::setPicture($author);
    //             }
    //         }

    //         if ($author) {
    //             $author = $author->refresh();
    //         } else {
    //             $author = false;
    //         }

    //         return $author;
    //     }

    //     return false;
    // }

    // public static function setLocalDescription(Author $author): Author
    // {
    //     if (File::exists(public_path('storage/data/authors.json'))) {
    //         $json = Storage::disk('public')->get('raw/authors.json');
    //         $json = json_decode($json);
    //         foreach ($json as $key => $value) {
    //             if ($key === $author->slug) {
    //                 $author->description = $value->description ?? null;
    //                 $author->link = $value->link ?? null;
    //                 $author->save();

    //                 return $author;
    //             }
    //         }

    //         return $author;
    //     }

    //     return $author;
    // }

    // public static function setLocalNotes(Author $author): Author
    // {
    //     if (File::exists(public_path('storage/data/authors-notes.json'))) {
    //         $json = Storage::disk('public')->get('raw/authors.json');
    //         $json = json_decode($json);
    //         foreach ($json as $key => $value) {
    //             if ($key === $author->slug) {
    //                 $author->note = $value->note ?? null;
    //                 $author->save();

    //                 return $author;
    //             }
    //         }

    //         return $author;
    //     }

    //     return $author;
    // }

    // public static function setWikipediaPicture(Author $author, WikipediaProvider $wikipediaProvider, bool $debug = false): Author
    // {
    //     try {
    //         $picture = WikipediaProvider::getPictureFile($wikipediaProvider);
    //         self::setPicture($author, $picture);
    //     } catch (\Throwable $th) {
    //         if ($debug) {
    //             echo "\nNo wikipedia picture for $wikipediaProvider->query\n";
    //         }
    //     }

    //     return $author;
    // }

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

    /**
     * Set default picture
     */
    public static function setDefaultPicture(Author $author): Author
    {
        $disk = 'authors';
        if (! $author->getFirstMediaUrl($disk)) {
            $path = database_path('seeders/media/authors/no-picture.jpg');
            $cover = File::get($path);
            
            $media = new MediaTools($author, $author->slug, $disk);
            $media->setMedia($cover);
            $media->setColor();
        }

        return $author;
    }

    /**
     * Set local picture from `public/storage/data/pictures-authors`
     * Only JPG file with author slug as name.
     */
    public static function setLocalPicture(Author $author): Author
    {
        $disk = 'authors';

        $path = public_path("storage/data/pictures-$disk");
        $files = BookshelvesTools::getDirectoryFiles($path);

        $cover = null;
        foreach ($files as $key => $file) {
            if (pathinfo($file)['filename'] === $author->slug) {
                $cover = file_get_contents($file);
            }
        }
        if ($cover) {
            $author->clearMediaCollection($disk);
            $media = new MediaTools($author, $author->slug, $disk);
            $media->setMedia($cover);
            $media->setColor();
        }

        return $author;
    }

    public static function setWikiDescription(Author $author, WikipediaProvider $wiki):Author
    {
        $author->description = BookshelvesTools::stringLimit($wiki->extract, 1000);
        $author->link = $wiki->page_url;
        $author->save();

        return $author;
    }

    public static function setWikiPicture(Author $author, WikipediaProvider $wiki):Author
    {
        $picture = $wiki->getPictureFile();
        $disk = 'authors';

        if ($picture && $author->slug !== 'author-unknown') {
            $author->clearMediaCollection($disk);

            $media = new MediaTools($author, $author->slug, $disk);
            $media->setMedia($picture);
            $media->setColor();
        }

        return $author;
    }
}
