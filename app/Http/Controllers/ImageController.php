<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Signatures\SignatureFactory;

class ImageController extends Controller
{
    public function glide(string $path, Request $request)
    {
        if ($key = config('glide.key')) {
            try {
                SignatureFactory::create($key)
                    ->validateRequest($request->path(), $request->only([
                        'ts', 'w', 'h', 'fit', 's',
                    ]))
                ;
            } catch (SignatureException $e) {
                abort(403);
            }
        }

        $server = ServerFactory::create([
            'response' => new SymfonyResponseFactory(),
            'source' => Storage::disk('public')->getDriver(),
            'cache' => storage_path('glide'),
            'driver' => config('glide.driver'),
        ]);

        if (! $server->sourceFileExists($path)) {
            abort(404);
        }

        return $server->getImageResponse($path, $request->query());
    }
}
