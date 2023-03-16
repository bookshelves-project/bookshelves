<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;

class UploadController extends Controller
{
    #[Get('/upload', name: 'upload')]
    public function index()
    {
        return view('admin::pages.upload');
    }
}
