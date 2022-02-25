<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\RouteAttributes\Attributes\Post;

class UploadController extends Controller
{
    /**
     * Image upload from Wysiwyg.
     */
    #[Post('/upload', name: 'upload')]
    public function upload(Request $request)
    {
        if (! ($file = $request->file('file'))) {
            abort(400);
        }

        $path = $file->store('upload', 'files');

        return [
            'location' => Storage::disk('files')->url($path),
        ];
    }
}
