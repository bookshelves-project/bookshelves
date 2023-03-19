<?php

namespace App\Engines\Book\Parser\Parsers;

use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;

class PdfParser
{
    protected array $data = [];

    protected function __construct(
        protected ParserModule&ParserModuleInterface $module,
    ) {
    }

    /**
     * Parse file name to generate Book.
     *
     * Example: `La_Longue_Guerre.Terry_Pratchett&Stephen_Baxter.fr.La_Longue_Terre.2.Pocket.2017-02-09.9782266266284`
     * like `Original_Title.Author_Name&Other_Author_Name.Language.Serie_Title.Volume.Publisher.Date.Identifier`
     */
    public static function make(ParserModule&ParserModuleInterface $module): ?self
    {
        return new self($module);
    }

    public function execute(): ParserModule
    {
        $this->module->parse($this->data);

        return $this->module;
    }
}
