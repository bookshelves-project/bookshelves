<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('languages')]
class LanguageController extends Controller
{
    #[Get('/', name: 'api.languages.index')]
    public function index()
    {
        return response()->json(Language::query()->orderBy('name')->get());
    }
}
