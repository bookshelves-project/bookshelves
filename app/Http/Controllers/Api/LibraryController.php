<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('libraries')]
class LibraryController extends Controller
{
    #[Get('/', name: 'api.libraries.index')]
    public function index()
    {
        return response()->json([
            'data' => Library::all(),
        ]);
    }
}
