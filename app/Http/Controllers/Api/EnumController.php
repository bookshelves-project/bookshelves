<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EnumService;

class EnumController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => EnumService::list(),
        ]);
    }
}
