<?php

namespace App\Http\Controllers\Api;

use App\Enums\ContactSubjectEnum;
use Kiwilan\Steward\Enums\PublishStatusEnum;
use Spatie\RouteAttributes\Attributes\Get;
use Str;

class MainController extends ApiController
{
    #[Get('/', name: 'index')]
    public function index()
    {
        return [
            'enums' => route('api.enums'),
            'data' => [
                'contents' => route('api.contents.index'),
                'pages' => route('api.pages.index'),
                'posts' => route('api.posts.index'),
                'references' => route('api.references.index'),
                'services' => route('api.services.index'),
                'team-members' => route('api.team-members.index'),
            ],
        ];
    }

    /**
     * GET enums.
     *
     * Get all enums.
     */
    #[Get('/enums', name: 'enums')]
    public function enums()
    {
        $contact_sujects = ContactSubjectEnum::toArray();
        $publish_statuses = PublishStatusEnum::toArray();

        return response()->json([
            'data' => [
                Str::kebab('ContactSubjectEnum') => $contact_sujects,
                Str::kebab('PublishStatusEnum') => $publish_statuses,
            ],
        ]);
    }
}
