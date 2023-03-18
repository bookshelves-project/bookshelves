<?php

namespace App\Engines;

use App\Engines\Parser\Models\BookEntityIdentifier;
use App\Engines\Parser\Modules\CbzModule;
use App\Engines\Parser\Modules\EpubModule;
use App\Engines\Parser\Modules\NameModule;
use App\Engines\Parser\Modules\PdfModule;
use App\Engines\Parser\Parsers\BookFile;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\Console;
use Transliterator;

/**
 * Parser engine for eBook.
 */
class ParserEngine
{
    /** @var string[] */
    protected array $contributor = [];

    /** @var BookEntityAuthor[] */
    protected array $creators = [];

    /** @var BookEntityIdentifier[] */
    protected array $identifiers = [];

    /** @var string[] */
    protected array $tags = [];

    protected function __construct(
        protected ?string $title = null,
        protected ?string $slugSort = null,
        protected ?string $titleSerieSort = null,
        protected ?string $slug = null,
        protected ?string $titleSlugLang = null,
        protected ?string $description = null,
        protected ?DateTime $releasedOn = null,
        protected ?string $date = null,
        protected ?string $publisher = null,
        protected ?string $language = null,
        protected ?string $rights = null,
        protected ?string $serie = null,
        protected ?string $serieSlug = null,
        protected ?string $serieSlugLang = null,
        protected ?string $serieSort = null,
        protected ?int $volume = null,
        protected ?int $pageCount = null,
        protected ?string $fileName = null,
        protected ?string $filePath = null,
        protected ?BookTypeEnum $type = null,
        protected ?string $coverName = null,
        protected ?string $coverExtension = null,
        protected ?string $coverFile = null,
        protected ?BookFormatEnum $format = null,
        protected bool $debug = false,
    ) {
    }

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

    /**
     * Transform OPF file to ParserEngine.
     */
    public static function make(BookFile $file, bool $debug = false): ?ParserEngine
    {
        $extension = pathinfo($file->path(), PATHINFO_EXTENSION);
        $fileName = pathinfo($file->path(), PATHINFO_BASENAME);
        $formats = BookFormatEnum::toNames();
        $console = Console::make();

        if (! array_key_exists($extension, $formats)) {
            $console->print("{$file->path()} ParserEngine error: extension is not recognized");

            return null;
        }

        $self = new ParserEngine();

        $self->fileName = $fileName;
        $self->filePath = $file->path();
        $self->format = BookFormatEnum::tryFrom($extension);
        $self->type = $file->type();
        $self->debug = $debug;

        $self = match ($self->format) {
            BookFormatEnum::cbz => CbzModule::make($self),
            BookFormatEnum::epub => EpubModule::make($self),
            BookFormatEnum::pdf => PdfModule::make($self),
            BookFormatEnum::cbr => CbzModule::make($self)->rar(),
            default => null,
        };

        if (! $self || null === $self->title) {
            // $console->print('Try to get data from name');
            $self = NameModule::make($self);
        }

        if (! $self) {
            $console->print("{$file->path()} ParserEngine error: format {$extension} not recognized");

            return null;
        }

        if (null === $self->title) {
            $console->print("{$file->path()} ParserEngine error: can't get title {$extension}");

            return null;
        }

        if (null === $self->language) {
            $self->language = 'unknown';
        }

        $title = Str::limit($self->title, 250);
        $self->title = Str::replace('`', '’', $title);
        $self->rights = Str::limit($self->rights, 250);

        $self->slugSort = ParserEngine::generateSortTitle($self->title, $self->language);
        $self->slug = Str::slug($self->title);
        $self->titleSlugLang = ParserEngine::generateSlug($self->title, $self->type->value, $self->language);

        $self->serieSlug = Str::slug($self->serie);
        $self->serieSlugLang = $self->serie ? ParserEngine::generateSlug($self->serie, $self->type->value, $self->language) : null;
        $self->serieSort = ParserEngine::generateSortTitle($self->serie, $self->language);
        $self->titleSerieSort = ParserEngine::generateSortSerie($self->title, $self->serie, $self->volume, $self->language);

        $self->description = ParserEngine::htmlToText($self->description);
        $resetCreators = false;

        foreach ($self->creators as $creator) {
            if ('' === $creator->name) {
                $resetCreators = true;
            }
        }

        if ($resetCreators) {
            $self->creators = [];
        }

        if ($self->date && ! str_contains($self->date, '0101')) {
            try {
                $self->releasedOn = new DateTime($self->date);
            } catch (\Throwable $th) {
                // throw $th;
            }
        }

        if ($self->debug) {
            $console->print("{$self->title}");
            $self_print = clone $self;
            $self_print->coverFile = $self_print->coverFile
                ? 'available (removed into this JSON)' : $self_print->coverFile;
            ParserEngine::printFile($self_print, "{$self->fileName}-parser.json");
        }

        return $self;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function slug(): ?string
    {
        return $this->slug;
    }

    public function slugSort(): ?string
    {
        return $this->slugSort;
    }

    public function titleSlugLang(): ?string
    {
        return $this->titleSlugLang;
    }

    public function titleSerieSort(): ?string
    {
        return $this->titleSerieSort;
    }

    public function serieSlug(): ?string
    {
        return $this->serieSlug;
    }

    public function serieSlugLang(): ?string
    {
        return $this->serieSlugLang;
    }

    public function serieSort(): ?string
    {
        return $this->serieSort;
    }

    public function serie(): ?string
    {
        return $this->serie;
    }

    public function volume(): ?int
    {
        return $this->volume;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function language(): ?string
    {
        return $this->language;
    }

    public function rights(): ?string
    {
        return $this->rights;
    }

    public function date(): ?string
    {
        return $this->date;
    }

    public function releasedOn(): ?DateTime
    {
        return $this->releasedOn;
    }

    public function format(): ?BookFormatEnum
    {
        return $this->format;
    }

    public function type(): ?BookTypeEnum
    {
        return $this->type;
    }

    public function coverName(): ?string
    {
        return $this->coverName;
    }

    public function coverExtension(): ?string
    {
        return $this->coverExtension;
    }

    public function coverFile(): ?string
    {
        return $this->coverFile;
    }

    public function filePath(): ?string
    {
        return $this->filePath;
    }

    public function fileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Get the value of creators.
     *
     * @return BookEntityAuthor[]
     */
    public function creators(): array
    {
        return $this->creators;
    }

    /**
     * Get the value of contributor.
     *
     * @return string[]
     */
    public function contributor(): array
    {
        return $this->contributor;
    }

    public function publisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * Get the value of identifiers.
     *
     * @return BookEntityIdentifier[]
     */
    public function identifiers(): array
    {
        return $this->identifiers;
    }

    public function debug(): bool
    {
        return $this->debug;
    }

    /**
     * Generate `slug` with `title`,  `BookTypeEnum` and `language_slug`.
     */
    public static function generateSlug(string $title, string $type, string $language): string
    {
        return Str::slug($title.' '.$type.' '.$language);
    }

    /**
     * Try to get sort title.
     * Example: `collier-de-la-reine` from `Le Collier de la Reine`.
     */
    public static function generateSortTitle(string|null $title, string $language): ?string
    {
        if (! $title) {
            return null;
        }

        $slugSort = $title;
        $articles = self::DETERMINERS;

        $articlesLang = $articles['en'];

        if (array_key_exists($language, $articles)) {
            $articlesLang = $articles[$language];
        }

        foreach ($articlesLang as $key => $value) {
            $slugSort = preg_replace('/^'.preg_quote($value, '/').'/i', '', $slugSort);
        }

        $transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);
        $slugSort = $transliterator->transliterate($slugSort);
        $slugSort = strtolower($slugSort);

        return Str::slug(mb_convert_encoding($slugSort, 'UTF-8'));
    }

    /**
     * Generate full title sort.
     * Example: `miserables-01_fantine` from `Les Misérables, volume 01 : Fantine`.
     */
    public static function generateSortSerie(string $title, string|null $serieTitle, int|null $volume, string $language): string
    {
        $serie = null;

        if ($serieTitle) {
            // @phpstan-ignore-next-line
            $volume = strlen($volume) < 2 ? '0'.$volume : $volume;
            $serie = $serieTitle.' '.$volume;
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
        if (! $html) {
            return null;
        }

        $text = str_replace("\n", '', $html); // remove break line
        $text = trim(strip_tags($text, $allow)); // remove html tags and trim

        $regex = '@(https?://([-\\w\\.]+[-\\w])+(:\\d+)?(/([\\w/_\\.#-]*(\\?\\S+)?[^\\.\\s])?).*$)@';
        $text = preg_replace($regex, ' ', $text); // remove links
        $text = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $text); // remove style

        return trim($text);
    }

    public static function printFile(mixed $file, string $name, bool $raw = false): bool
    {
        $console = Console::make();

        try {
            $file = $raw
                ? $file
                : json_encode($file, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            return Storage::disk('public')->put("/debug/{$name}", $file);
        } catch (\Throwable $th) {
            $console->print(__METHOD__, $th);
        }

        return false;
    }
}
