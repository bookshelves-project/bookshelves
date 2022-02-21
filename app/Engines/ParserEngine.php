<?php

namespace App\Engines;

use App\Engines\ParserEngine\BookCreator;
use App\Engines\ParserEngine\BookIdentifier;
use App\Engines\ParserEngine\OpfParser;
use DateTime;
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
        public ?string $slug_lang = null,
        /** @var BookCreator[] $creators */
        public ?array $creators = [],
        public ?array $contributor = [],
        public ?string $description = null,
        public ?DateTime $released_on = null,
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
        public ?string $cover = null,
        public ?string $cover_extension = null,
        public ?string $epub_path = null,
    ) {
    }

    /**
     * Transform OPF file to ParserEngine.
     */
    public static function create(string $epub_path, bool $debug = false, bool $print = false): ParserEngine
    {
        $engine = new ParserEngine();
        $parser = OpfParser::create($epub_path, $debug);

        $engine->title = $parser->title;
        $engine->slug_sort = self::generateSortTitle($parser->title);
        $engine->slug = Str::slug($parser->title);
        $engine->slug_lang = Str::slug($parser->title.' '.$parser->language);
        $engine->creators = $parser->creators;
        $engine->contributor = $parser->contributor;
        $engine->description = self::htmlToText($parser->description);
        $engine->released_on = $parser->released_on ?? null;
        $engine->identifiers = $parser->identifiers;
        $engine->publisher = $parser->publisher;
        $engine->subjects = $parser->subjects;
        $engine->language = $parser->language;
        $engine->rights = substr($parser->rights, 0, 255);
        $engine->serie = $parser->serie;
        $engine->serie_slug = Str::slug($parser->serie);
        $engine->serie_slug_lang = Str::slug($parser->serie.' '.$parser->language);
        $engine->serie_sort = self::generateSortTitle($parser->serie);
        $engine->volume = $parser->volume;
        $engine->epub_path = $epub_path;

        $engine->title_serie_sort = self::generateSortSerie(
            $engine->title,
            $engine->volume,
            $engine->serie,
        );

        if (! $print) {
            $engine->cover = $parser->cover_file;
            $engine->cover_extension = $parser->cover_extension;
        }

        return $engine;
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

    public static function htmlToText(?string $html, ?string $allow = '<br>'): string
    {
        return trim(strip_tags($html, $allow));
    }
}
