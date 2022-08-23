<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Content\ContentCollectionResource;
use App\Http\Resources\Content\ContentResource;
use App\Models\Content;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Content
 *
 * APIs for Content.
 */
#[Prefix('contents')]
class ContentController extends ApiController
{
    /**
     * GET Content[].
     *
     * Get all Pages ordered by `key`.
     *
     * @responseField data Content[] List of pages.
     */
    #[Get('/', name: 'api.contents.index')]
    public function index()
    {
        $models = Content::orderBy('key')->get();

        return ContentCollectionResource::collection($models);
    }

    /**
     * GET Content.
     */
    #[Get('/{content_key}', name: 'api.contents.show')]
    public function show(Content $content)
    {
        return ContentResource::make($content);
    }
}
