<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Query\QueryBuilderAddon;
use App\Query\QueryExporter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Language
 *
 * Endpoint to get Languages data.
 */
class LanguageController extends ApiController
{
    /**
     * GET Languages list.
     */
    public function index()
    {
        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(Language::class, withCount: ['books'])
            ->allowedFilters([
            ])
            ->allowedSorts([
                'id',
                'name',
            ])
            ->defaultSort('name')
        ;

        return QueryExporter::create($query)
            ->resource(LanguageResource::class)
            ->get()
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
