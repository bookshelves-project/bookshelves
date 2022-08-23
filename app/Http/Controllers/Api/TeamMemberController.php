<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TeamMember\TeamMemberCollectionResource;
use App\Models\TeamMember;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Creations
 *
 * APIs for Creations.
 */
#[Prefix('team-members')]
class TeamMemberController extends ApiController
{
    /**
     * GET TeamMember[].
     *
     * Get all TeamMember ordered by `sort`.
     *
     * @responseField data TeamMember[] List of team members.
     */
    #[Get('/', name: 'api.team-members.index')]
    public function index()
    {
        $models = TeamMember::orderBy('sort')->get();

        return TeamMemberCollectionResource::collection($models);
    }
}
