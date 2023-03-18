<?php

namespace App\Engines\Parser\Modules\Interface;

interface XmlInterface
{
    /**
     * Parse XML file to extract metadata.
     *
     * @param  array<string, mixed>  $metadata
     */
    public function parse(array $metadata): ParserModule;
}
