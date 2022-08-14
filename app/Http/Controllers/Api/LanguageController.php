<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\LanguageQuery;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;

/**
 * @group Relation: Language
 *
 * Endpoint to get Languages data.
 */
class LanguageController extends ApiController
{
    /**
     * GET Language[].
     */
    public function index(Request $request)
    {
        return app(LanguageQuery::class)
            ->make(QueryOption::create(
                request: $request,
                resource: LanguageResource::class,
                orderBy: 'name',
                withExport: false,
                sortAsc: true,
                full: false
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Language.
     */
    public function show(Language $language)
    {
        return LanguageResource::make($language);
    }
}
