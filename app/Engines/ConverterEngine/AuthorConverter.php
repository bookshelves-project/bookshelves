<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\BookCreator;
use App\Models\Author;
use App\Models\Book;
use App\Services\DirectoryParserService;
use App\Services\MediaService;
use App\Services\WikipediaService\WikipediaQuery;
use File;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AuthorConverter
{
    public const DISK = 'authors';

    public function __construct(
        public ?string $firstname,
        public ?string $lastname,
        public ?string $role,
    ) {
    }

    /**
     * Convert BookCreator to AuthorConverter from config order.
     */
    public static function create(BookCreator $creator): AuthorConverter
    {
        $orderClassic = config('bookshelves.authors.order_natural');

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
     * Generate Author[] for Book from ParserEngine.
     */
    public static function generate(ParserEngine $parser, Book $book): Collection
    {
        $authors = [];
        if (empty($parser->creators)) {
            $creator = new BookCreator(
                name: 'Unknown Author',
                role: 'aut'
            );
            $converter = AuthorConverter::create($creator);
            $author = AuthorConverter::convert($converter, $creator);
            array_push($authors, $author);
        } else {
            foreach ($parser->creators as $key => $creator) {
                $converter = AuthorConverter::create($creator);
                $skipHomonys = config('bookshelves.authors.detect_homonyms');
                if ($skipHomonys) {
                    $lastname = Author::whereFirstname($converter->lastname)->first();
                    if ($lastname) {
                        $exist = Author::whereLastname($converter->firstname)->first();
                        if ($exist) {
                            $author = $exist;
                        } else {
                            $author = AuthorConverter::convert($converter, $creator);
                        }
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
            // TODO: log
            $book->authors()->save($author);
            AuthorConverter::tags($author);
        }
        $book->refresh();

        return $book->authors;
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

    /**
     * Set default picture.
     */
    public static function setDefaultPicture(Author $author): Author
    {
        $disk = self::DISK;
        if (! $author->getFirstMediaUrl($disk)) {
            $path = database_path('seeders/media/authors/no-picture.jpg');
            $cover = File::get($path);

            MediaService::create($author, $author->slug, $disk)
                ->setMedia($cover)
                ->setColor()
            ;
        }

        return $author;
    }

    /**
     * Get local picture from `public/storage/data/pictures-authors`
     * Only JPG file with author slug as name.
     */
    public static function getLocalPicture(Author $author): ?string
    {
        $disk = self::DISK;
        $path = public_path("storage/data/pictures-{$disk}");
        $cover = null;

        $files = DirectoryParserService::getDirectoryFiles($path);

        foreach ($files as $file) {
            if (pathinfo($file)['filename'] === $author->slug) {
                $cover = base64_encode(file_get_contents($file));
            }
        }

        return $cover;
    }

    /**
     * Set local picture from `public/storage/data/pictures-authors`
     * Only JPG file with author slug as name.
     */
    public static function setLocalPicture(Author $author): Author
    {
        $disk = self::DISK;
        $cover = self::getLocalPicture($author);

        if ($cover) {
            $author->clearMediaCollection($disk);
            MediaService::create($author, $author->slug, $disk)
                ->setMedia($cover)
                ->setColor()
            ;
        }

        return $author;
    }

    public static function setWikiDescription(Author $author): Author
    {
        if ($author->wikipedia && ! $author->description && ! $author->link) {
            $author->description = Str::limit($author->wikipedia->extract, 1000);
            $author->link = $author->wikipedia->page_url;
            $author->save();
        }

        return $author;
    }

    /**
     * Set wiki picture if local not exist
     * Otherwise, set local picture.
     */
    public static function setWikiPicture(Author $author): Author
    {
        if ($author->getMedia('authors')->isEmpty()) {
            $disk = self::DISK;
            $cover = self::getLocalPicture($author);
            if ($cover) {
                self::setLocalPicture($author);

                return $author;
            }

            $picture = null;
            if ($author->wikipedia) {
                $picture = WikipediaQuery::getPictureFile($author->wikipedia->picture_url);
            }

            if ($picture && 'author-unknown' !== $author->slug) {
                $author->clearMediaCollection($disk);
                MediaService::create($author, $author->slug, $disk)
                    ->setMedia($picture)
                    ->setColor()
                ;
            }
        }

        return $author;
    }

    public static function setPicturePlaceholder(Author $author): Author
    {
        if ($author->getMedia('authors')->isEmpty()) {
            $placeholder = public_path('assets/images/no-author.jpg');
            $disk = self::DISK;
            $author->clearMediaCollection($disk);
            MediaService::create($author, $author->slug, $disk)
                ->setMedia(base64_encode(File::get($placeholder)))
                ->setColor()
            ;
        }

        return $author;
    }

    /**
     * Create Author if not exist.
     */
    private static function convert(AuthorConverter $converter, BookCreator $creator): Author
    {
        return Author::firstOrCreate([
            'lastname' => $converter->lastname,
            'firstname' => $converter->firstname,
            'name' => "{$converter->firstname} {$converter->lastname}",
            'slug' => Str::slug("{$converter->lastname} {$converter->firstname}", '-'),
            'role' => $creator->role,
        ]);
    }
}
