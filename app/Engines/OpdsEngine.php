<?php

namespace App\Engines;

use App\Engines\OpdsEngine\Modules\Interface\ModuleInterface;
use App\Engines\OpdsEngine\Modules\NotSupportedModule;
use App\Engines\OpdsEngine\Modules\Version1_2Module;
use App\Services\ConverterService;
use Illuminate\Http\Request;

class OpdsEngine
{
    public const FEED = [
        [
            'key' => 'authors',
            'model' => 'Author',
            'title' => 'Authors',
            'content' => 'Authors availables',
            'cover_thumbnail' => '',
            'route' => 'opds.authors.index',
        ],
        [
            'key' => 'series',
            'model' => 'Serie',
            'title' => 'Series',
            'content' => 'Series availables',
            'cover_thumbnail' => '',
            'route' => 'opds.series.index',
        ],
    ];

    public Request $request;

    public string $version;

    public object $feed;

    public static function create(Request $request): ModuleInterface
    {
        $engine = new OpdsEngine();
        $engine->request = $request;
        $engine->version = $request->version;
        $engine->feed = ConverterService::arrayToObject(self::FEED);

        return match ($request->version) {
            '1.2' => Version1_2Module::create($engine),
            default => NotSupportedModule::create($engine),
        };
    }
}
