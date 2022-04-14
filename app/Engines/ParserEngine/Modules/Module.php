<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;

abstract class Module
{
    public function __construct(
        public ParserEngine $engine,
        public ?array $metadata = null,
    ) {
    }
}
