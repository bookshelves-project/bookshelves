<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;

/**
 * @group Endpoints
 */
class CountController extends ApiController
{
    /**
     * GET Count.
     *
     * Get count of entities for a selected collection. Available for Book, Serie and Author.
     *
     * @queryParam entities required `key` of enums.models' list. Example: author,book,serie
     * @queryParam languages required `slug` of languages' list `meta.slug`. Example: fr,en
     */
    public function count(Request $request)
    {
        // http://localhost:8000/api/v1/count?entities=book,author,serie&languages=fr,en

        $entities = $request->get('entities');
        $languages = $request->get('languages');

        $models_count = [];
        $count_languages = [];

        if ($entities) {
            $models_raw = explode(',', $entities);
            $models = [];
            foreach ($models_raw as $key => $value) {
                $models[$value] = 'App\Models\\'.ucfirst($value);
            }

            foreach ($models as $key => $model_name) {
                $count = $model_name::count();
                $models_count[$key] = $count;
            }
        }

        if ($languages) {
            $languages_raw = explode(',', $languages);
            foreach ($languages_raw as $key => $value) {
                $count = Book::whereLanguageSlug($value)->count();
                $count_languages[$value] = $count;
            }
        }

        return response()->json([
            'data' => [
                'entities' => $models_count,
                'languages' => $count_languages,
            ],
        ]);
    }
}
