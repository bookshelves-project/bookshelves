<?php

namespace App\Engines\Book\Parser\Models;

use Illuminate\Support\Str;
use Transliterator;

class BookEntityExtra
{
    protected function __construct(
        protected ?string $slugSort = null,
        protected ?string $titleSerieSort = null,
        protected ?string $slug = null,
        protected ?string $titleSlugLang = null,
        protected ?string $serieSlug = null,
        protected ?string $serieSlugLang = null,
        protected ?string $serieSort = null,
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

    public function slugSort(): ?string
    {
        return $this->slugSort;
    }

    public function titleSerieSort(): ?string
    {
        return $this->titleSerieSort;
    }

    public function slug(): ?string
    {
        return $this->slug;
    }

    public function titleSlugLang(): ?string
    {
        return $this->titleSlugLang;
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

    public function toArray(): array
    {
        return [
            'slugSort' => $this->slugSort,
            'titleSerieSort' => $this->titleSerieSort,
            'slug' => $this->slug,
            'titleSlugLang' => $this->titleSlugLang,
            'serieSlug' => $this->serieSlug,
            'serieSlugLang' => $this->serieSlugLang,
            'serieSort' => $this->serieSort,
        ];
    }

    public function __toString(): string
    {
        return "{$this->slugSort} {$this->titleSerieSort}";
    }

    public static function make(BookEntity $book): self
    {
        $self = new self();
        $self->slugSort = $self->generateSortTitle($book->title(), $book->language());
        $self->slug = Str::slug($book->title());
        $self->titleSlugLang = $self->generateSlug($book->title(), $book->file()->type()->value, $book->language());
        $self->serieSlug = Str::slug($book->serie());
        $self->serieSlugLang = $book->serie() ? $self->generateSlug($book->serie(), $book->file()->type()->value, $book->language()) : null;
        $self->serieSort = $self->generateSortTitle($book->serie(), $book->language());
        $self->titleSerieSort = $self->generateSortSerie($book->title(), $book->serie(), $book->volume(), $book->language());

        return $self;
    }

    /**
     * Generate `slug` with `title`,  `BookTypeEnum` and `language_slug`.
     */
    private function generateSlug(string $title, string $type, string $language): string
    {
        return Str::slug($title.' '.$type.' '.$language);
    }

    /**
     * Try to get sort title.
     * Example: `collier-de-la-reine` from `Le Collier de la Reine`.
     */
    private function generateSortTitle(string|null $title, string $language): ?string
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
    private function generateSortSerie(string $title, string|null $serieTitle, int|null $volume, string $language): string
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
}
