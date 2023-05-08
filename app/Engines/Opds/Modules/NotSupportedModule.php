<?php

namespace App\Engines\Opds\Modules;

use App\Engines\Opds\Modules\Interface\Module;
use App\Engines\Opds\Modules\Interface\ModuleInterface;
use App\Engines\Opds\OpdsJsonResponse;
use App\Engines\OpdsEngine;

class NotSupportedModule extends Module implements ModuleInterface
{
    public static function make(OpdsEngine $opds): ModuleInterface
    {
        return new NotSupportedModule($opds);
    }

    public function response(): OpdsJsonResponse
    {
        return $this->responseNotSupported();
    }

    public function search(): OpdsJsonResponse
    {
        return $this->responseNotSupported();
    }

    public function responseNotSupported(): OpdsJsonResponse
    {
        return OpdsJsonResponse::make([
            'message' => "Version {$this->opds->version} is not supported.",
        ], 400);
    }
}
