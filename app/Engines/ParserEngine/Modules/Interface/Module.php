<?php

namespace App\Engines\ParserEngine\Modules\Interface;

use App\Engines\ParserEngine;

abstract class Module
{
    public function __construct(
        public ParserEngine $engine,
        public ?array $metadata = null,
    ) {
    }
}
