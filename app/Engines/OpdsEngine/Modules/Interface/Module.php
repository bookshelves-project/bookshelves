<?php

namespace App\Engines\OpdsEngine\Modules\Interface;

use App\Engines\OpdsEngine;

abstract class Module
{
    public function __construct(
        public OpdsEngine $engine,
    ) {
    }
}
