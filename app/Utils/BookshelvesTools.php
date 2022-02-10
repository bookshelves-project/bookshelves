<?php

namespace App\Utils;

use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Throwable;

class BookshelvesTools
{
    /**
     * Global search on Book, Serie and Author.
     */
    public static function searchGlobal(string $searchTermRaw): array
    {
        $searchTerm = mb_convert_encoding($searchTermRaw, 'UTF-8', 'UTF-8');
        $authors = Author::whereLike(['name', 'firstname', 'lastname'], $searchTerm)->with('media')->get();
        $series = Serie::whereLike(['title', 'authors.name'], $searchTerm)->with(['authors', 'media'])->get();
        $books = Book::whereLike(['title', 'authors.name', 'serie.title', 'identifier_isbn', 'identifier_isbn13'], $searchTerm)->with(['authors', 'media'])->doesntHave('serie')->orderBy('serie_id')->orderBy('volume')->get();

        $authors = EntityResource::collection($authors);
        $series = EntityResource::collection($series);
        $books = EntityResource::collection($books);
        $collection = collect([]);
        $collection = $collection->merge($authors);
        $collection = $collection->merge($series);
        $collection = $collection->merge($books);

        return $collection->all();
    }

    /**
     * Chunk a collection by first character.
     */
    public static function chunkByAlpha(Collection $collection, string $attribute)
    {
        return $collection->mapToGroups(function ($item, $key) use ($attribute) {
            return self::isAlpha($item->{$attribute}[0]) ? [strtoupper($item->{$attribute}[0]) => $item] : ['#' => $item];
        })->sortKeys();
    }

    /**
     * Check if character is alpha.
     *
     * @param mixed $toCheck
     */
    public static function isAlpha($toCheck)
    {
        return preg_match('/^[a-zA-Z]+$/', $toCheck);
    }

    /**
     * Convert bytes to human readable filesize.
     */
    public static function humanFilesize(string|int $bytes, ?int $decimals = 2): string
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
     * Parse directory (recursive).
     *
     * @param mixed $dir
     *
     * @return \Generator<mixed, mixed, mixed, void>
     */
    public static function getDirectoryFiles($dir)
    {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (! is_dir($path)) {
                yield $path;
            } elseif ('.' != $value && '..' != $value) {
                yield from self::getDirectoryFiles($path);
                yield $path;
            }
        }
    }

    /**
     * Print in console.
     */
    public static function console(string $method, ?Throwable $throwable, ?string $extra_message = null)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()->setStyle('fire', $outputStyle);

        $output->writeln("<fire>Error about {$method}:</>");
        if ($throwable) {
            $output->writeln($throwable->getMessage());
            $output->writeln($throwable->getFile());
        } else {
            $output->writeln($extra_message);
        }
    }

    /**
     * Limit length of a string and sanitize.
     */
    public static function stringLimit(string|null $text, int $limit): string
    {
        $content = '';
        if ($text) {
            $isUTF8 = mb_check_encoding($text, 'UTF-8');
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $text);

            if ($isUTF8) {
                $content = trim($content);
                if ($limit && strlen($content) > $limit) {
                    $content = substr($content, 0, $limit);
                }
                $content = strip_tags($content);
                $content = Str::ascii($content);
                $content = str_replace('<<', '"', $content);
                $content = str_replace('>>', '"', $content);
                $content = trim($content);
                $content = preg_replace('/\\([^)]+\\)/', '', $content);
                $content = preg_replace('/\s\s+/', ' ', $content);
            }
        }

        return $content.'...';
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
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        ];

        $string = preg_replace(array_keys($utf8), array_values($utf8), $text);

        return $string ? $string : '';
    }

    public static function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = strtok($str, "{$envKey}=");

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }

    /**
     * Deprecated.
     */
    public static function convertPicture(Model $model, string $name, string $type = 'thumbnail'): string
    {
        $extension = config('bookshelves.cover_extension');

        $format = config('image.covers.'.$type);
        $disk = $model->getTable();

        $converted_pictures_directory = config('bookshelves.converted_pictures_directory');
        $base_path = storage_path("app/public/{$converted_pictures_directory}/{$disk}/{$type}/");
        $path = $base_path.$name.'.'.$extension;

        if (! File::exists($path)) {
            if (! is_dir($base_path)) {
                mkdir($base_path, 0777, true);
            }

            try {
                // @phpstan-ignore-next-line
                Image::load($model->getFirstMediaPath($disk))
                    ->fit('crop', $format['width'], $format['height'])
                    ->save($path)
                ;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        return getUrlStorage($path);
    }
}
