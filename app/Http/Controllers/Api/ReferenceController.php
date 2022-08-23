<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Reference\ReferenceCollectionResource;
use App\Http\Resources\Reference\ReferenceResource;
use App\Models\Reference;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Creations
 *
 * APIs for Creations.
 */
#[Prefix('references')]
class ReferenceController extends ApiController
{
    /**
     * GET Reference[].
     *
     * Get all Reference ordered by `presentation_year`.
     *
     * @responseField data Reference[] List of references.
     */
    #[Get('/', name: 'api.references.index')]
    public function index(Request $request)
    {
        $models = Reference::published()
            ->orderBy('presentation_year', 'desc')
            ->paginate($request->get('limit') ?? '32')
        ;

        return ReferenceCollectionResource::collection($models);
    }

    /**
     * GET Reference.
     */
    #[Get('/{reference_slug}', name: 'api.references.show')]
    public function show(Reference $reference)
    {
        return ReferenceResource::make($reference);
    }
}
