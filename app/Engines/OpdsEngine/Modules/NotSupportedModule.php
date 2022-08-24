<?php

namespace App\Engines\OpdsEngine\Modules;

use App\Engines\OpdsEngine;
use App\Engines\OpdsEngine\Modules\Interface\Module;
use App\Engines\OpdsEngine\Modules\Interface\ModuleInterface;
use App\Enums\EntityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class NotSupportedModule extends Module implements ModuleInterface
{
    public static function create(OpdsEngine $engine): ModuleInterface
    {
        return new NotSupportedModule($engine);
    }

    public function index(): JsonResponse
    {
        return $this->responseNotSupported();
    }

    public function search(): JsonResponse
    {
        return $this->responseNotSupported();
    }

    public function entities(EntityEnum $entity, Collection|Model $collection, ?string $title = null): JsonResponse
    {
        return $this->responseNotSupported();
    }

    public function responseNotSupported(): JsonResponse
    {
        return response()->json([
            'message' => "Version {$this->engine->version} is not supported.",
        ]);
    }
}
