<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CmsController extends Controller
{
    public function home()
    {
        return Inertia::render('CMS/Home');
    }
}
