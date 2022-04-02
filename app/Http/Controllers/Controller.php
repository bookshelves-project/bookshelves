<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function getsizes(Request $request)
    {
        $page = $request->get('size') ? $request->get('size') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'size' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);
    }
}
