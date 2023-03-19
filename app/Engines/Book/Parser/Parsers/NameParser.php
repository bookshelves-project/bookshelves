<?php

namespace App\Engines\Book\Parser\Parsers;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Engines\Book\Parser\Models\BookEntityIdentifier;
use App\Engines\Book\Parser\Modules\Extractor\NameExtractor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use Closure;

class NameParser
{
    protected array $data = [];

    /** @var BookEntityAuthor[] */
    protected ?array $creators = [];

    /** @var BookEntityIdentifier[] */
    protected ?array $identifiers = null;

    protected function __construct(
        protected ParserModule $module,
        protected ?string $title = null,
        protected ?string $language = null,
        protected ?string $serie = null,
        protected ?int $volume = null,
        protected ?string $date = null,
        protected ?string $publisher = null,
    ) {
    }

    /**
     * Parse file name to generate Book.
     *
     * Example: `La_Longue_Guerre.Terry_Pratchett&Stephen_Baxter.fr.La_Longue_Terre.2.Pocket.2017-02-09.9782266266284`
     * like `Original_Title.Author_Name&Other_Author_Name.Language.Serie_Title.Volume.Publisher.Date.Identifier`
     */
    public static function make(ParserModule $module): ?self
    {
        return new self($module);
    }

    /**
     * @param Closure(array $metadata): void  $closure
     */
    public function parse(Closure $closure): ParserModule
    {
        $filename = pathinfo($this->module->file()->path(), PATHINFO_FILENAME);
        $parsing = explode('.', $filename);

        if (! is_array($parsing)) {
            return $this->module;
        }

        $list = [
            'title',
            'creators',
            'language',
            'serie',
            'volume',
            'publisher',
            'date',
            'identifiers',
        ];

        foreach ($list as $key => $value) {
            $this->data[$value] = $this->parseName($parsing, $key);
        }

        $closure($this->data);

        return $this->module;
    }

    private function parseName(array $parsing, int $key): ?string
    {
        return array_key_exists($key, $parsing) ? NameExtractor::nullValueCheck($parsing[$key]) : null;
    }
}
