<?php

namespace App\Providers\Bookshelves;

use App\Models\Tag;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Identifier;
use Illuminate\Support\Str;
use App\Providers\MetadataExtractor\Parsers\Creator;
use App\Providers\MetadataExtractor\MetadataExtractor;

class ConvertMetadataExtractor
{
    /**
     * Generate new Book with all relations.
     *
     * @param MetadataExtractor $metadataExtractor
     * @param bool              $is_debug
     *
     * @return Book
     */
    public static function run(MetadataExtractor $metadataExtractor, ?bool $is_debug = false): Book
    {
        $bookIfExist = Book::whereSlug(Str::slug($metadataExtractor->title, '-'))->first();
        $book = null;
        if (! $bookIfExist) {
            $book = self::book($metadataExtractor);
            $book = self::authors($metadataExtractor, $book);
            $book = self::tags($metadataExtractor, $book);
            $book = self::publisher($metadataExtractor, $book);
            $book = self::serie($metadataExtractor, $book);
            $language = Language::firstOrCreate([
                'slug' => $metadataExtractor->language,
            ]);
            $book->language()->associate($language->slug);
            $identifier = Identifier::firstOrCreate([
                'isbn'   => $metadataExtractor->identifiers->isbn,
                'isbn13' => $metadataExtractor->identifiers->isbn13,
                'doi'    => $metadataExtractor->identifiers->doi,
                'amazon' => $metadataExtractor->identifiers->amazon,
                'google' => $metadataExtractor->identifiers->google,
            ]);
            $book->identifier()->associate($identifier);
            $book->save();
            if (! $is_debug) {
                ExtraDataGenerator::getDataFromGoogleBooks(identifier: $identifier, book: $book);
            }
        }
        if (! $book) {
            $book = $bookIfExist;
        }

        return $book;
    }

    public static function book(MetadataExtractor $metadataExtractor): Book
    {
        return Book::firstOrCreate([
            'title'        => $metadataExtractor->title,
            'slug'         => Str::slug($metadataExtractor->title, '-'),
            'title_sort'   => $metadataExtractor->title_sort,
            'contributor'  => $metadataExtractor->contributor,
            'description'  => $metadataExtractor->description,
            'date'         => $metadataExtractor->date,
            'rights'       => $metadataExtractor->rights,
            'volume'       => $metadataExtractor->volume,
        ]);
    }

    public static function authors(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        $authors = [];
        /** @var Creator $creator */
        foreach ($metadataExtractor->creators as $key => $creator) {
            $author_name = explode(' ', $creator->name);
            $lastname = $author_name[sizeof($author_name) - 1];
            array_pop($author_name);
            $firstname = implode(' ', $author_name);
            $author = Author::firstOrCreate([
                'lastname'  => $lastname,
                'firstname' => $firstname,
                'name'      => "$firstname $lastname",
                'slug'      => Str::slug("$lastname $firstname", '-'),
                'role'      => $creator->role,
            ]);
            array_push($authors, $author);
        }
        foreach ($authors as $key => $author) {
            $book->authors()->save($author);
        }

        return $book;
    }

    public static function tags(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        foreach ($metadataExtractor->subjects as $key => $subject) {
            $tagIfExist = Tag::whereSlug(Str::slug($subject))->first();
            $tag = null;
            if (! $tagIfExist && strlen($subject) > 1 && strlen($subject) < 30) {
                $tag = Tag::firstOrCreate([
                    'name' => $subject,
                    'slug' => Str::slug($subject),
                ]);
            }
            if (! $tag) {
                $tag = $tagIfExist;
            }

            if ($tag) {
                $book_tags = $book->tags;
                $book_tags_list = [];
                foreach ($book_tags as $key => $tagIn) {
                    array_push($book_tags_list, $tagIn->slug);
                }
                if (! in_array($tag->slug, $book_tags_list)) {
                    $book->tags()->save($tag);
                    $book->save();
                }
            }
        }

        return $book;
    }

    public static function publisher(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        if ($metadataExtractor->publisher) {
            $publisherIfExist = Publisher::whereSlug(Str::slug($metadataExtractor->publisher))->first();
            $publisher = null;
            if (! $publisherIfExist) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $metadataExtractor->publisher,
                    'slug' => Str::slug($metadataExtractor->publisher),
                ]);
            } else {
                $publisher = $publisherIfExist;
            }

            $book->publisher()->associate($publisher);
        }

        return $book;
    }

    public static function serie(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        if ($metadataExtractor->serie) {
            $serieIfExist = Serie::whereSlug(Str::slug($metadataExtractor->serie))->first();
            $serie = null;
            if (! $serieIfExist) {
                $serie = Serie::firstOrCreate([
                    'title'      => $metadataExtractor->serie,
                    'title_sort' => $metadataExtractor->serie_sort,
                    'slug'       => Str::slug($metadataExtractor->serie),
                ]);
            } else {
                $serie = $serieIfExist;
            }

            $authors_serie = [];
            foreach ($serie->authors as $key => $author) {
                array_push($authors_serie, $author->slug);
            }
            $book_authors = $book->authors;
            foreach ($book_authors as $key => $author) {
                if (! in_array($author->slug, $authors_serie)) {
                    $serie->authors()->save($author);
                }
            }

            $book->serie()->associate($serie);
        }

        return $book;
    }
}
