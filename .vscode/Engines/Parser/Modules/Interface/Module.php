<?php

namespace App\Engines\Parser\Modules\Interface;

use App\Engines\ParserEngine;

abstract class Module
{
    public function __construct(
        public ParserEngine $parser,
        public ?array $metadata = null,
    ) {
    }
}
