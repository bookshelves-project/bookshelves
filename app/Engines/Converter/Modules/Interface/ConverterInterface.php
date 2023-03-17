<?php

namespace App\Engines\Converter\Modules\Interface;

use App\Engines\ConverterEngine;

interface ConverterInterface
{
    public static function make(ConverterEngine $converter);
}
