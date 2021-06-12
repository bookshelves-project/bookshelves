<?php

namespace App\Utils;

use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Identifier;
use Illuminate\Support\Str;
use App\Http\Resources\Search\SearchBookResource;
use App\Http\Resources\Search\SearchSerieResource;
use App\Http\Resources\Search\SearchAuthorResource;

class BookshelvesTools
{
    /**
     * Global search on Book, Serie and Author.
     */
    public static function searchGlobal(string $searchTermRaw): array
    {
        $searchTerm = mb_convert_encoding($searchTermRaw, 'UTF-8', 'UTF-8');
        $authors = Author::whereLike(['name', 'firstname', 'lastname'], $searchTerm)->get();
        $series = Serie::whereLike(['title', 'authors.name'], $searchTerm)->get();
        $books = Book::whereLike(['title', 'authors.name', 'serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();
        $identifier = Identifier::whereLike(['isbn', 'isbn13', 'doi', 'amazon', 'google'], $searchTerm)->first();
        if ($identifier) {
            $book = $identifier->book;
            $books = collect([$book]);

            $books = SearchBookResource::collection($books);
            $collection = collect([]);
            $collection = $collection->merge($books);
        } else {
            $authors = SearchAuthorResource::collection($authors);
            $series = SearchSerieResource::collection($series);
            $books = SearchBookResource::collection($books);
            $collection = collect([]);
            $collection = $collection->merge($authors);
            $collection = $collection->merge($series);
            $collection = $collection->merge($books);
        }

        return $collection->all();
    }

    /**
     * Global search on Book, Serie and Author.
     */
    public static function searchGlobalIdentifier(string $searchTermRaw): array
    {
        $searchTerm = mb_convert_encoding($searchTermRaw, 'UTF-8', 'UTF-8');
        $identifier = Identifier::whereLike(['isbn', 'isbn13', 'doi', 'amazon', 'google'], $searchTerm)->first();
        $book = $identifier->book;
        $books = collect([$book]);

        $books = SearchBookResource::collection($books);
        $collection = collect([]);
        $collection = $collection->merge($books);

        return $collection->all();
    }

    /**
     * DISCONTINUED
     * Remove accents from string.
     *
     * @param mixed $stripAccents
     */
    public static function stripAccents($stripAccents): string
    {
        return strtr(
            utf8_decode($stripAccents),
            utf8_decode(
                'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'
            ),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
    }

    /**
     * Convert bytes to human readable filesize.
     *
     * @param string|int $bytes
     */
    public static function humanFilesize(string | int $bytes, ?int $decimals = 2): string
    {
        $sz = [
            'B',
            'Ko',
            'Mo',
            'Go',
            'To',
            'Po',
        ];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@$sz[$factor];
    }

    /**
     * Limit length of a string and sanitize.
     */
    public static function stringLimit(string | null $text, int $limit): string
    {
        $content = '';
        if ($text) {
            $isUTF8 = mb_check_encoding($text, 'UTF-8');
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $text);

            if ($isUTF8) {
                $content = trim($content);
                if ($limit && strlen($content) > $limit) {
                    $content = substr($content, 0, $limit).'...';
                }
                $content = strip_tags($content);
                $content = Str::ascii($content);
                $content = str_replace('<<', '"', $content);
                $content = str_replace('>>', '"', $content);
                $content = trim($content);
                $content = preg_replace("/\([^)]+\)/", '', $content);
                $content = preg_replace('/\s\s+/', ' ', $content);
            }
        }

        return $content;

        // $content = substr($text, 0, $limit);
        // $content = trim($content);
        // $content = $content.'...';
        // $content = self::hyphenize($content);

        // return $content;
    }

    /**
     * Sanitize string.
     */
    public static function hyphenize(string $string): string
    {
        $dict = [
            "I'm" => 'I am',
            // Add your own replacements here
        ];

        return strtolower(
            preg_replace(
                ['#[\\s-]+#', '#[^A-Za-z0-9. -]+#'],
                ['-', ''],
              // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
              self::cleanString(
                  str_replace( // preg_replace can be used to support more complicated replacements
                      array_keys($dict),
                      array_values($dict),
                      urldecode($string)
                  )
              )
            )
        );
    }

    /**
     * Clean accents and special characters of string.
     */
    public static function cleanString(string $text): string
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u'  => 'A',
            '/[ÍÌÎÏ]/u'   => 'I',
            '/[íìîï]/u'   => 'i',
            '/[éèêë]/u'   => 'e',
            '/[ÉÈÊË]/u'   => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u'  => 'O',
            '/[úùûü]/u'   => 'u',
            '/[ÚÙÛÜ]/u'   => 'U',
            '/ç/'         => 'c',
            '/Ç/'         => 'C',
            '/ñ/'         => 'n',
            '/Ñ/'         => 'N',
            '/–/'         => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'  => ' ', // Literally a single quote
            '/[“”«»„]/u'  => ' ', // Double quote
            '/ /'         => ' ', // nonbreaking space (equiv. to 0x160)
        ];

        $string = preg_replace(array_keys($utf8), array_values($utf8), $text);

        return $string ? $string : '';
    }
}
