<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Language;

/**
 * @group Language
 *
 * Endpoint to get Languages data.
 */
class LanguageController extends Controller
{
    /**
     * GET Language collection.
     *
     * Get all languages available.
     */
    public function index()
    {
        $langs = Language::all();

        return LanguageResource::collection($langs);
    }
}
