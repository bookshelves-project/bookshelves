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
    public static function make(OpdsEngine $opds): ModuleInterface
    {
        return new VersionOneDotTwoModule($opds);
    }

    public function response(): OpdsXmlResponse
    {
        $xml = OpdsXmlConverter::make($this->opds->app, $this->opds->entries, $this->opds->title);

        return OpdsXmlResponse::make($xml);
    }

    public function search(): OpdsXmlResponse
    {
        $xml = OpdsXmlConverter::make($this->opds->app, $this->opds->entries, $this->opds->title);

        return OpdsXmlResponse::make($xml);
    }
}
