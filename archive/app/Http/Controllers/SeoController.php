<?php

namespace App\Http\Controllers;

class SeoController extends Controller
{
    public function robots()
    {
        return response(view('robots'))->header('Content-Type', 'text/plain');
    }
}
