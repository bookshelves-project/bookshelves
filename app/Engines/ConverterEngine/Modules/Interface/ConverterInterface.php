<?php

namespace App\Engines\ConverterEngine\Modules\Interface;

use App\Engines\ConverterEngine;

interface ConverterInterface
{
    public static function make(ConverterEngine $converter_engine);
}
