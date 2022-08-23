<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Service\ServiceCollectionResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Service;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Creations
 *
 * APIs for Creations.
 */
#[Prefix('services')]
class ServiceController extends ApiController
{
    /**
     * GET Service[].
     *
     * Get all Service ordered by `sort`.
     *
     * @responseField data Service[] List of pages.
     */
    #[Get('/', name: 'api.services.index')]
    public function index()
    {
        $models = Service::orderBy('sort')->get();

        return ServiceCollectionResource::collection($models);
    }

    /**
     * GET Service.
     */
    #[Get('/{service_slug}', name: 'api.services.show')]
    public function show(Service $service)
    {
        return ServiceResource::make($service);
    }
}
