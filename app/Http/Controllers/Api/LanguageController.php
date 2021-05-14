<?php

namespace App\Http\Controllers\Api;

use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;

class LanguageController extends Controller
{
    public function index()
    {
        $langs = Language::all();

        return LanguageResource::collection($langs);
    }
}
