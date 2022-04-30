<?php

namespace App\Engines;

use App\Engines\ParserEngine\Models\BookCreator;
use App\Engines\ParserEngine\Models\BookIdentifier;
use App\Engines\ParserEngine\Modules\CbzModule;
use App\Engines\ParserEngine\Modules\EpubModule;
use App\Engines\ParserEngine\Modules\NameModule;
use App\Engines\ParserEngine\Modules\PdfModule;
use App\Engines\ParserEngine\Parsers\FilesTypeParser;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
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
    /** @var string[][] */
    public const DETERMINERS = [
        'en' => [
            'the ',
            'a ',
        ],
        'fr' => [
            'les ',
            "l'",
            'le ',
            'la ',
            "d'un",
            "d'",
            'une ',
            'au ',
        ],
    ];

    /** @var BookCreator[] */
    public ?array $creators = [];

    /** @var BookIdentifier[] */
    public ?array $identifiers = null;

    public ?BookFormatEnum $format;

    /** @var string[] */
    public ?array $tags = [];

    public function __construct(
        public ?string $title = null,
        public ?string $slug_sort = null,
        public ?string $title_serie_sort = null,
        public ?string $slug = null,
        public ?string $title_slug_lang = null,
        public ?array $contributor = [],
        public ?string $description = null,
        public ?DateTime $released_on = null,
        public ?string $date = null,
        public ?string $publisher = null,
        public ?string $language = null,
        public ?string $rights = null,
        public ?string $serie = null,
        public ?string $serie_slug = null,
        public ?string $serie_slug_lang = null,
        public ?string $serie_sort = null,
        public ?int $volume = null,
        public ?int $page_count = null,
        public ?string $file_name = null,
        public ?string $file_path = null,
        public ?BookTypeEnum $type = null,
        public ?string $cover_name = null,
        public ?string $cover_extension = null,
        public ?string $cover_file = null,
        public ?bool $debug = false,
    ) {
    }

    /**
     * Transform OPF file to ParserEngine.
     */
    public static function create(FilesTypeParser $file, bool $debug = false): ?ParserEngine
    {
        $extension = pathinfo($file->path, PATHINFO_EXTENSION);
        $file_name = pathinfo($file->path, PATHINFO_BASENAME);
        $formats = BookFormatEnum::toNames();

        if (! array_key_exists($extension, $formats)) {
            ConsoleService::print("{$file->path} ParserEngine error: extension is not recognized");

            return null;
        }

        $parser = new ParserEngine();

        $parser->file_name = $file_name;
        $parser->file_path = $file->path;
        $parser->format = BookFormatEnum::tryFrom($extension);
        $parser->type = $file->type;
        $parser->debug = $debug;

        $engine = match ($parser->format) {
            BookFormatEnum::cbz => CbzModule::create($parser),
            BookFormatEnum::epub => EpubModule::create($parser),
            BookFormatEnum::pdf => PdfModule::create($parser),
            BookFormatEnum::cbr => CbzModule::create($parser, true),
            default => false,
        };
        if (! $engine || null === $engine->title) {
            // ConsoleService::print('Try to get data from name');
            $engine = NameModule::create($parser);
        }

        if (! $engine) {
            ConsoleService::print("{$file->path} ParserEngine error: format {$extension} not recognized");
            return null;
        }

        if (null === $engine->title) {
            ConsoleService::print("{$file->path} ParserEngine error: can't get title {$extension}");
            return null;
        }

        if (null === $engine->language) {
            $engine->language = 'any';
        }

        $title = Str::limit($engine->title, 250);
        $engine->title = Str::replace('`', '’', $title);
        $engine->rights = Str::limit($engine->rights, 250);

        $engine->slug_sort = ParserEngine::generateSortTitle($engine->title, $engine->language);
        $engine->slug = Str::slug($engine->title);
        $engine->title_slug_lang = ParserEngine::generateSlug($engine->title, $engine->type->value, $engine->language);

        $engine->serie_slug = Str::slug($engine->serie);
        $engine->serie_slug_lang = $engine->serie ? ParserEngine::generateSlug($engine->serie, $engine->type->value, $engine->language) : null;
        $engine->serie_sort = ParserEngine::generateSortTitle($engine->serie, $engine->language);
        $engine->title_serie_sort = ParserEngine::generateSortSerie($engine->title, $engine->serie, $engine->volume, $engine->language);

        $engine->description = ParserEngine::htmlToText($engine->description);
        $reset_creators = false;
        foreach ($engine->creators as $creator) {
            if ('' === $creator->name) {
                $reset_creators = true;
            }
        }
        if ($reset_creators) {
            $engine->creators = [];
        }

        if ($engine->date && ! str_contains($engine->date, '0101')) {
            try {
                $engine->released_on = new DateTime($engine->date);
            } catch (\Throwable $th) {
                // throw $th;
            }
        }

        if ($engine->debug) {
            ConsoleService::print("{$engine->title}");
            $engine_print = clone $engine;
            $engine_print->cover_file = $engine_print->cover_file
                ? 'available (removed into this JSON)' : $engine_print->cover_file;
            ParserEngine::printFile($engine_print, "{$engine->file_name}-parser.json");
        }

        return $engine;
    }

    public static function generateSlug(string $title, string $type, string $language): string
    {
        return Str::slug($title.' '.$type.' '.$language);
    }

    /**
     * Try to get sort title.
     * Example: `collier-de-la-reine` from `Le Collier de la Reine`.
     */
    public static function generateSortTitle(string|null $title, string $language): string|false
    {
        if ($title) {
            $slug_sort = $title;
            $articles = self::DETERMINERS;

            $articles_lang = $articles['en'];
            if (array_key_exists($language, $articles)) {
                $articles_lang = $articles[$language];
            }
            foreach ($articles_lang as $key => $value) {
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
    public static function generateSortSerie(string $title, string|null $serie_title, int|null $volume, string $language): string
    {
        $serie = null;
        if ($serie_title) {
            // @phpstan-ignore-next-line
            $volume = strlen($volume) < 2 ? '0'.$volume : $volume;
            $serie = $serie_title.' '.$volume;
            $serie = Str::slug(self::generateSortTitle($serie, $language)).'_';
        }
        $title = Str::slug(self::generateSortTitle($title, $language));

        return "{$serie}{$title}";
    }

    /**
     * Strip HTML tags.
     */
    public static function htmlToText(?string $html, ?array $allow = ['br', 'p', 'ul', 'li']): ?string
    {
        $text = null;
        if ($html) {
            $text = str_replace("\n", '', $html); // remove break line
            $text = trim(strip_tags($text, $allow)); // remove html tags and trim

            $regex = '@(https?://([-\\w\\.]+[-\\w])+(:\\d+)?(/([\\w/_\\.#-]*(\\?\\S+)?[^\\.\\s])?).*$)@';
            $text = preg_replace($regex, ' ', $text); // remove links
            $text = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $text); // remove style
            $text = trim($text);
        }

        return $text;
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
