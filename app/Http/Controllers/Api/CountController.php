<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Count
 */
class CountController extends Controller
{
    /**
    * GET Count
    *
    * Get count of entities for a selected collection. Available for Book, Serie and Author.
    *
    * @queryParam entity required filters[book,serie,author] To get count for an entity. Example: book
    */
    public function count(Request $request)
    {
        $entity = $request->get('entity');
        $entity = $entity ? $entity : null;
        $entityParameters = ['book', 'serie', 'author'];
        if (! $entity && ! in_array($entity, $entityParameters)) {
            return response()->json(
                "Invalid 'entity' query parameter, must be like '".implode("' or '", $entityParameters)."'",
                400
            );
        }

        $lang = $request->get('lang');
        $lang = $lang ? $lang : null;
        $langParameters = ['fr', 'en'];
        if ($lang && ! in_array($lang, $langParameters)) {
            return response()->json(
                "Invalid 'lang' query parameter, must be like '".implode("' or '", $langParameters)."'",
                400
            );
        }

        $model_name = 'App\Models\\'.ucfirst($entity);
        $entities_count = 0;

        try {
            if ($lang) {
                $entities_count = $model_name::whereLanguageSlug($lang)->get();
                $entities_count = $entities_count->count();
            } else {
                $entities_count = $model_name::count();
            }
        } catch (\Throwable $th) {
        }

        return $entities_count;
    }
}
