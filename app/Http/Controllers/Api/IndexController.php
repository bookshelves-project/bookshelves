<?php

namespace App\Http\Controllers\Api;

use App\Enums\ContactSubjectEnum;
use Illuminate\Support\Str;
use Kiwilan\Steward\Enums\PublishStatusEnum;
use Spatie\RouteAttributes\Attributes\Get;

class IndexController extends Controller
{
    #[Get('/', name: 'api.index')]
    public function index()
    {
        return response()->json([
            'name' => config('app.name').' API',
            'version' => 'v1',
            'routes' => [
                'application' => $this->getRouteData(config('app.url'), 'Main application', false),
                'catalog' => $this->getRouteData('catalog.index', 'UI for eReader browser to get books on it'),
                'opds' => $this->getRouteData('front.opds', 'OPDS API for application which use it'),
                'webreader' => $this->getRouteData('front.webreader', 'UI to read directly an eBook into browser'),
                'admin' => $this->getRouteData('filament.pages.dashboard', 'For admin to manage data.'),
                'documentation' => $this->getRouteData(config('bookshelves.documentation_url'), 'Documentation for developers', false),
                // 'api-doc' => $this->getRouteData(route('scribe'), 'API documentation to use data on others applications', false),
                'repository' => $this->getRouteData(config('bookshelves.repository_url'), 'Repository of this application', false),
            ],
        ], 200);
    }

    /**
     * GET enums.
     *
     * Get all enums.
     */
    #[Get('/enums', name: 'api.enums')]
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

    /**
     * @hideFromAPIDocumentation
     *
     * @param  mixed  $isLaravelRoute
     */
    private function getRouteData(string $route, string $description, $isLaravelRoute = true)
    {
        return [
            'route' => $isLaravelRoute ? route($route) : $route,
            'description' => $description,
        ];
    }
}
