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
use App\Providers\EpubParser\EpubParser;

class ConvertEpubParser
{
    /**
     * Generate new Book with all relations.
     *
     * @param EpubParser $epubParser
     * @param bool       $is_debug
     *
     * @return Book
     */
    public static function run(EpubParser $epubParser, ?bool $is_debug = false): Book
    {
        $bookIfExist = Book::whereSlug(Str::slug($epubParser->title, '-'))->first();
        $book = null;
        if (! $bookIfExist) {
            $book = Book::firstOrCreate([
                'title'        => $epubParser->title,
                'slug'         => Str::slug($epubParser->title, '-'),
                'title_sort'   => $epubParser->title_sort,
                'contributor'  => $epubParser->contributor,
                'description'  => $epubParser->description,
                'date'         => $epubParser->date,
                'rights'       => $epubParser->rights,
                'serie_number' => $epubParser->serie_number,
            ]);
            $authors = [];
            foreach ($epubParser->creators as $key => $creator) {
                $author_data = explode(' ', $creator);
                $lastname = $author_data[sizeof($author_data) - 1];
                array_pop($author_data);
                $firstname = implode(' ', $author_data);
                $author = Author::firstOrCreate([
                    'lastname'  => $lastname,
                    'firstname' => $firstname,
                    'name'      => "$firstname $lastname",
                    'slug'      => Str::slug("$lastname $firstname", '-'),
                ]);
                array_push($authors, $author);
            }
            foreach ($authors as $key => $author) {
                $book->authors()->save($author);
            }
            foreach ($epubParser->subjects as $key => $subject) {
                $tagIfExist = Tag::whereSlug(Str::slug($subject))->first();
                $tag = null;
                if (! $tagIfExist && strlen($subject) > 3 && strlen($subject) < 30) {
                    $tag = Tag::firstOrCreate([
                        'name' => $subject,
                        'slug' => Str::slug($subject),
                    ]);
                }
                if ($tag) {
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
            if ($epubParser->publisher) {
                $publisherIfExist = Serie::whereSlug(Str::slug($epubParser->serie))->first();
                $publisher = null;
                if (! $publisherIfExist) {
                    $publisher = Publisher::firstOrCreate([
                        'name' => $epubParser->publisher,
                        'slug' => Str::slug($epubParser->publisher),
                    ]);
                } else {
                    $publisher = $publisherIfExist;
                }

                $book->publisher()->associate($publisher);
            }
            if ($epubParser->serie) {
                $serieIfExist = Serie::whereSlug(Str::slug($epubParser->serie))->first();
                $serie = null;
                if (! $serieIfExist) {
                    $serie = Serie::firstOrCreate([
                        'title'      => $epubParser->serie,
                        'title_sort' => $epubParser->serie_sort,
                        'slug'       => Str::slug($epubParser->serie),
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
            $language = Language::firstOrCreate([
                'slug' => $epubParser->language,
            ]);
            $language = self::generateLanguageFlag($language);
            $book->language()->associate($language->slug);
            $identifier = Identifier::firstOrCreate([
                'isbn'   => $epubParser->identifiers->isbn,
                'isbn13' => $epubParser->identifiers->isbn13,
                'doi'    => $epubParser->identifiers->doi,
                'amazon' => $epubParser->identifiers->amazon,
                'google' => $epubParser->identifiers->google,
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

    public static function generateLanguageFlag(Language $language): Language
    {
        $languages_display = [
            'en' => 'English',
            'gb' => 'English',
            'fr' => 'French',
        ];
        $languages_id = [
            'en' => 'gb',
            'gb' => 'gb',
            'fr' => 'fr',
        ];
        $lang_id = $language->slug;
        $lang_flag = array_key_exists($lang_id, $languages_id) ? $languages_id[$lang_id] : $lang_id;

        $language->flag = "https://www.countryflags.io/$lang_flag/flat/32.png";
        $language->display = array_key_exists($lang_id, $languages_display) ? $languages_display[$lang_id] : $lang_id;
        $language->save();

        return $language;
    }
}
