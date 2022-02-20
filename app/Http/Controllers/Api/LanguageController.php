<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\LanguageQuery;
use App\Http\Resources\LanguageResource;
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
     * GET Languages list.
     */
    public function index(Request $request)
    {
        $paginate = $request->parseBoolean('paginate');

        return app(LanguageQuery::class)
            ->make(QueryOption::create(
                resource: LanguageResource::class,
                orderBy: 'name',
                withExport: false,
                sortAsc: true,
                withPagination: $paginate
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Language details.
     */
    public function show(Language $language)
    {
        return LanguageResource::make($language);
    }
}
