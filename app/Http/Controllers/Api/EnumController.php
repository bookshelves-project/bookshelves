<?php

namespace App\Http\Controllers\Api;

use App\Services\EnumService;

/**
 * @group Misc
 */
class EnumController extends ApiController
{
    /**
     * GET Enums.
     */
    public function index()
    {
        return response()->json([
            'data' => EnumService::list(),
        ]);
    }
}
