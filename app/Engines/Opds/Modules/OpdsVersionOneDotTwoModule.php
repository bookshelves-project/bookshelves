<?php

namespace App\Engines\Opds\Modules;

use App\Engines\Opds\Modules\Interface\Module;
use App\Engines\Opds\OpdsXmlConverter;
use App\Engines\Opds\OpdsXmlResponse;
use App\Engines\OpdsEngine;

/**
 * OPDS 1.2 Module
 *
 * @docs https://specs.opds.io/opds-1.2
 */
class OpdsVersionOneDotTwoModule
{
    protected function __construct(
        public OpdsEngine $opds,
    ) {
    }

    public static function response(OpdsEngine $opds): OpdsXmlResponse
    {
        $self = new OpdsVersionOneDotTwoModule($opds);
        $xml = OpdsXmlConverter::make($self->opds->app, $self->opds->entries, $self->opds->title);

        return OpdsXmlResponse::make($xml);
    }
}
