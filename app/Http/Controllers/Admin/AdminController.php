<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.pages.index');
    }

    public function documentation()
    {
        return view('admin.pages.documentation');
    }
}
