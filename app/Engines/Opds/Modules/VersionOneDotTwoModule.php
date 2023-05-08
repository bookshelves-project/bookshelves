<?php

namespace App\Engines\Opds\Modules;

use App\Engines\Opds\Modules\Interface\Module;
use App\Engines\Opds\Modules\Interface\ModuleInterface;
use App\Engines\Opds\OpdsXmlConverter;
use App\Engines\Opds\OpdsXmlResponse;
use App\Engines\OpdsEngine;

/**
 * OPDS 1.2 Module
 *
 * @docs https://specs.opds.io/opds-1.2
 */
class VersionOneDotTwoModule extends Module implements ModuleInterface
{
    public static function response(OpdsEngine $opds): OpdsXmlResponse
    {
        $self = new VersionOneDotTwoModule($opds);
        $xml = OpdsXmlConverter::make($self->opds->app, $self->opds->entries, $self->opds->title);

        return OpdsXmlResponse::make($xml);
    }
}
