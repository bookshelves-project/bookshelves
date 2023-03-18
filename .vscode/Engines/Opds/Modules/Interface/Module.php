<?php

namespace App\Engines\Opds\Modules\Interface;

use App\Engines\OpdsEngine;

abstract class Module
{
    public function __construct(
        public OpdsEngine $opds,
    ) {
    }
}
