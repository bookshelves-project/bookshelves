<?php

namespace App\Engines\ConverterEngine\Modules;

use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\Modules\Interface\ConverterInterface;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Enums\AuthorRoleEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AuthorConverter implements ConverterInterface
{
    public const DISK = MediaDiskEnum::cover;

    public function __construct(
        public ?string $firstname,
        public ?string $lastname,
        public ?string $role,
    ) {
    }

    /**
     * Generate Author[] for Book from ParserEngine and sync with Book.
     *
     * @return Collection<int,Author>
     */
    public static function make(ConverterEngine $converter_engine)
    {
        $authors = collect([]);
        // Anonymous author.
        if (empty($converter_engine->parser_engine->creators)) {
            $creator = new BookCreator(
                name: 'Anonymous',
                role: 'aut'
            );
            $author_converter = AuthorConverter::convert($creator);
            $author = AuthorConverter::generate($author_converter, $creator);
            $authors->push($author);
        } else {
            foreach ($converter_engine->parser_engine->creators as $creator) {
                $author_converter = AuthorConverter::convert($creator);
                $author = null;

                if (config('bookshelves.authors.detect_homonyms')) {
                    $lastname = Author::whereFirstname($author_converter->lastname)->first();

                    if ($lastname) {
                        $author = Author::whereLastname($author_converter->firstname)->first();
                    }
                }

                if (null === $author) {
                    $author = AuthorConverter::generate($author_converter, $creator);
                }
                $authors->push($author);
            }
        }

        $converter_engine->book->authors()->sync($authors->pluck('id'));
        $converter_engine->book->save();

        return $converter_engine->book->authors;
    }

    /**
     * Convert BookCreator to AuthorConverter from config order.
     */
    public static function convert(BookCreator $creator): AuthorConverter
    {
        $lastname = null;
        $firstname = null;

        $author_name = explode(' ', $creator->name);

        if (config('bookshelves.authors.order_natural')) {
            $lastname = $author_name[count($author_name) - 1];
            array_pop($author_name);
            $firstname = implode(' ', $author_name);
        } else {
            $firstname = $author_name[count($author_name) - 1];
            array_pop($author_name);
            $lastname = implode(' ', $author_name);
        }
        $role = $creator->role;
        $firstname = trim($firstname);
        $lastname = trim($lastname);

        return new AuthorConverter($firstname, $lastname, $role);
    }

    /**
     * Create Author if not exist.
     */
    private static function generate(AuthorConverter $converter_engine, BookCreator $creator): Author
    {
        $name = "{$converter_engine->lastname} {$converter_engine->firstname}";
        $name = trim($name);

        return Author::firstOrCreate([
            'lastname' => $converter_engine->lastname,
            'firstname' => $converter_engine->firstname,
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'role' => AuthorRoleEnum::tryFrom($converter_engine->role),
        ]);
    }
}
