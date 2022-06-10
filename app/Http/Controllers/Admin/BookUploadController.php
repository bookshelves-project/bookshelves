<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookUploadController extends Controller
{
    #[Get('upload', name: 'books.upload')]
    public function create()
    {
        return Inertia::render('book-upload/Create');
    }
}
