<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class WebreaderController extends Controller
{
    public function index()
    {
        return view('pages.api.webreader');
    }
}
