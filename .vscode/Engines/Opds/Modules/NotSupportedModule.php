<?php

namespace App\Engines\Opds\Modules;

use App\Engines\Opds\Modules\Interface\Module;
use App\Engines\Opds\Modules\Interface\ModuleInterface;
use App\Engines\OpdsEngine;
use App\Enums\EntityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class NotSupportedModule extends Module implements ModuleInterface
{
    public static function create(OpdsEngine $opds): ModuleInterface
    {
        return new NotSupportedModule($opds);
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
            'message' => "Version {$this->opds->version} is not supported.",
        ]);
    }
}
