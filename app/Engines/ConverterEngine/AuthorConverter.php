<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Enums\MediaDiskEnum;
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
    public const DISK = MediaDiskEnum::cover;

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
        $order_natural = config('bookshelves.authors.order_natural');
        $lastname = '';
        $firstname = '';

        $author_name = explode(' ', $creator->name);
        if ($order_natural) {
            $lastname = $author_name[sizeof($author_name) - 1];
            array_pop($author_name);
            $firstname = implode(' ', $author_name);
        } else {
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
                        $author = Author::whereLastname($converter->firstname)->first();
                        if (! $author) {
                            $author = AuthorConverter::convert($converter, $creator);
                        }
                    } else {
                        $author = AuthorConverter::convert($converter, $creator);
                    }
                } else {
                    $author = AuthorConverter::convert($converter, $creator);
                }
                array_push($authors, $author);
            }
        }

        foreach ($authors as $author) {
            $book->authors()->attach($author);
        }
        $book->save();

        return $book->authors;
    }

    /**
     * Create Author if not exist.
     */
    private static function convert(AuthorConverter $converter, BookCreator $creator): Author
    {
        return Author::firstOrCreate([
            'lastname' => $converter->lastname,
            'firstname' => $converter->firstname,
            'name' => "{$converter->lastname} {$converter->firstname}",
            'slug' => Str::slug("{$converter->lastname} {$converter->firstname}", '-'),
            'role' => $creator->role,
        ]);
    }
}
