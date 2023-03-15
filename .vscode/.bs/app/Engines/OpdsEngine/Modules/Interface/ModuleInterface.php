<?php

namespace App\Engines\OpdsEngine\Modules\Interface;

use App\Engines\OpdsEngine;
use App\Enums\EntityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

interface ModuleInterface
{
    public static function create(OpdsEngine $engine): ModuleInterface;

    public function index(): Response|JsonResponse;

    public function search(): Response|JsonResponse;

    public function entities(EntityEnum $entity, Collection|Model $collection, ?string $title = null): Response|JsonResponse;
}
