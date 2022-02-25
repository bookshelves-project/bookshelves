<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Inertia\Middleware;
use App\Enums\TagTypeEnum;
use App\Enums\BookTypeEnum;
use Illuminate\Http\Request;
use App\Enums\AuthorRoleEnum;
use App\Enums\ChartColorEnum;
use App\Enums\PostStatusEnum;
use App\Http\Resources\Admin\AuthResource;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'admin::app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'flash' => function () use ($request) {
                return $request->session()->get('flash', []);
            },
            'auth' => function () use ($request) {
                if (! $request->user()) {
                    return;
                }

                return AuthResource::make($request->user());
            },
            'enums' => function () {
                return collect([
                    'roles' => RoleEnum::class,
                    'post_statuses' => PostStatusEnum::class,
                    'tag_types' => TagTypeEnum::class,
                    'book_types' => BookTypeEnum::class,
                    'author_roles' => AuthorRoleEnum::class,
                    'chart_colors' => ChartColorEnum::class,
                ])
                    ->mapWithKeys(fn ($enum, $key) => [$key => $enum::toArray()])
                ;
            },
            'repositoryUrl' => config('app.repository_url'),
            'documentationUrl' => config('app.documentation_url'),
        ]);
    }
}
