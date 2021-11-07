<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

/**
 * @group Count
 *
 * Endpoint to get count of entities.
 */
class CountController extends Controller
{
    /**
     * GET Count.
     *
     * Get count of entities for a selected collection. Available for Book, Serie and Author.
     *
     * @queryParam entity required filters[book,serie,author] To get count for an entity. Example: book
     */
    public function count(Request $request)
    {
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
                'languages' => $count_languages
            ],
        ]);
    }
}
