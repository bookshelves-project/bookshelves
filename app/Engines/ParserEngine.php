<?php

namespace App\Engines;

use App\Engines\ParserEngine\BookCreator;
use App\Engines\ParserEngine\BookIdentifier;
use App\Engines\ParserEngine\Modules\OpfModule;
use App\Enums\BookFormatEnum;
use App\Services\ConsoleService;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Transliterator;

/**
 * Parser engine for eBook.
 */
class ParserEngine
{
    public function __construct(
        public ?string $title = null,
        public ?string $slug_sort = null,
        public ?string $title_serie_sort = null,
        public ?string $slug = null,
        public ?string $title_slug_lang = null,
        /** @var BookCreator[] $creators */
        public ?array $creators = [],
        public ?array $contributor = [],
        public ?string $description = null,
        public ?DateTime $released_on = null,
        public ?string $date = null,
        /** @var BookIdentifier[] $identifiers */
        public ?array $identifiers = null,
        public ?string $publisher = null,
        public ?array $subjects = [],
        public ?string $language = null,
        public ?string $rights = null,
        public ?string $serie = null,
        public ?string $serie_slug = null,
        public ?string $serie_slug_lang = null,
        public ?string $serie_sort = null,
        public ?int $volume = 0,
        public ?string $file_name = null,
        public ?string $file_path = null,
        public ?BookFormatEnum $format = null,
        public ?string $cover_name = null,
        public ?string $cover_extension = null,
        public ?string $cover_file = null,
        public ?bool $debug = false,
    ) {
    }

    /**
     * Transform OPF file to ParserEngine.
     */
    public static function create(string $file_path, bool $debug = false): ParserEngine|false
    {
        $extension = pathinfo($file_path)['extension'];
        $file_name = pathinfo($file_path)['basename'];
        $formats = BookFormatEnum::toArray();

        if (! in_array($extension, $formats)) {
            ConsoleService::print("{$file_path} ParserEngine error: extension is not recognized");

            return false;
        }

        $parser = new ParserEngine();
        $parser->file_name = $file_name;
        $parser->file_path = $file_path;
        $parser->format = BookFormatEnum::from($extension);
        $parser->debug = $debug;

        $parser = match ($parser->format) {
            BookFormatEnum::epub => OpfModule::create($parser),
            default => false,
        };

        if ($parser) {
            $parser->slug_sort = ParserEngine::generateSortTitle($parser->title);
            $parser->slug = Str::slug($parser->title);
            $parser->title_slug_lang = Str::slug($parser->title.' '.$parser->language);
            $parser->serie_slug = Str::slug($parser->serie);
            $parser->serie_slug_lang = Str::slug($parser->serie.' '.$parser->language);
            $parser->serie_sort = ParserEngine::generateSortTitle($parser->serie);
            $parser->title_serie_sort = ParserEngine::generateSortSerie($parser->title, $parser->volume, $parser->serie);
            $parser->description = ParserEngine::htmlToText($parser->description);
            $parser->released_on = ! str_contains($parser->date, '0101') ? new DateTime($parser->date) : null;

            if ($parser->debug) {
                ConsoleService::print("{$parser->title}");
                $parser_print = clone $parser;
                $parser_print->cover_file = $parser_print->cover_file
                    ? 'available (removed into this JSON)' : $parser_print->cover_file;
                ParserEngine::printFile($parser_print, "{$parser->file_name}-parser.json");
            }
        } else {
            ConsoleService::print("{$file_path} ParserEngine error: format not recognized");

            return false;
        }

        return $parser;
    }

    /**
     * Try to get sort title.
     * Example: `collier-de-la-reine` from `Le Collier de la Reine`.
     */
    public static function generateSortTitle(string|null $title): string|false
    {
        if ($title) {
            $slug_sort = $title;
            $articles = [
                'the ',
                'les ',
                "l'",
                'le ',
                'la ',
                // 'a ',
                "d'un",
                "d'",
                'une ',
                'au ',
            ];
            foreach ($articles as $key => $value) {
                $slug_sort = preg_replace('/^'.preg_quote($value, '/').'/i', '', $slug_sort);
            }
            $transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);
            $slug_sort = $transliterator->transliterate($slug_sort);
            $slug_sort = strtolower($slug_sort);

            return Str::slug(utf8_encode($slug_sort));
        }

        return false;
    }

    /**
     * Generate full title sort.
     * Example: `miserables-01_fantine` from `Les Misérables, volume 01 : Fantine`.
     */
    public static function generateSortSerie(string|null $title, int|null $volume, string|null $serie_title): string
    {
        $serie = null;
        if ($serie_title) {
            // @phpstan-ignore-next-line
            $volume = strlen($volume) < 2 ? '0'.$volume : $volume;
            $serie = $serie_title.' '.$volume;
            $serie = Str::slug(self::generateSortTitle($serie)).'_';
        }
        $title = Str::slug(self::generateSortTitle($title));

        return "{$serie}{$title}";
    }

    /**
     * Strip HTML tags.
     */
    public static function htmlToText(?string $html, ?string $allow = '<br>'): ?string
    {
        return $html ? trim(strip_tags($html, $allow)) : null;
    }

    public static function printFile(mixed $file, string $name, bool $raw = false): bool
    {
        try {
            $file = $raw
                ? $file
                : json_encode($file, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            return Storage::disk('public')->put("/debug/{$name}", $file);
        } catch (\Throwable $th) {
            ConsoleService::print(__METHOD__, $th);
        }

        return false;
    }
}
