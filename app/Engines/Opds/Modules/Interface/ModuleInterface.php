<?php

namespace App\Engines\Opds\Modules\Interface;

use App\Engines\Opds\OpdsJsonResponse;
use App\Engines\Opds\OpdsXmlResponse;
use App\Engines\OpdsEngine;

interface ModuleInterface
{
    public static function response(OpdsEngine $opds): OpdsXmlResponse|OpdsJsonResponse;
}
