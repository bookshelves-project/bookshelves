<?php

namespace App\Engines\Book\Parser\Parsers;

use App\Engines\Book\Parser\Modules\Extractor\NameExtractor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use Closure;

class NameParser extends BookParser
{
    protected function __construct(
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
        $self = new self();
        $self->setup($module);

        return $self;
    }

    /**
     * @param Closure(array $metadata): mixed  $closure
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
            $this->metadata[$value] = $this->parseName($parsing, $key);
        }

        $closure($this->metadata);

        return $this->module;
    }

    private function parseName(array $parsing, int $key): ?string
    {
        return array_key_exists($key, $parsing) ? NameExtractor::nullValueCheck($parsing[$key]) : null;
    }
}
