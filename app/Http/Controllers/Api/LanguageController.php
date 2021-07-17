<?php

namespace App\Http\Controllers\Api;

use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;

/**
 * @group Language
 */
class LanguageController extends Controller
{
    /**
     * @response {
     *  "id": 4,
     *  "name": "Jessica Jones",
     *  "roles": ["admin"]
     * }
     */
    public function index()
    {
        $langs = Language::all();

        return LanguageResource::collection($langs);
    }
}
