<?php

namespace App\Engines;

use App\Engines\OpdsEngine\Modules\Version1_2Module;
use App\Engines\OpdsEngine\XmlResponse;
use App\Services\ConverterService;
use Illuminate\Http\Request;

class OpdsEngine
{
    public Request $request;
    public string $version;
    public ?string $query;
    public object $feed;

    public static function create(Request $request)
    {
        if ($request->version) {
            $engine = new OpdsEngine();
            $engine->request = $request;
            $engine->version = $request->version;
            $engine->query = $request->get('q');
            $engine->feed = ConverterService::arrayToObject(XmlResponse::FEED);

            $exist = match ($request->version) {
                '1.2' => Version1_2Module::create($engine),
                default => false,
            };

            if ($exist) {
                return $exist;
            }

            return abort(404);
        }

        return false;
    }
}
