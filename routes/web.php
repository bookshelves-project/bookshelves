<?php

use Illuminate\Support\Facades\Route;
use Knuckles\Scribe\Http\Controller as ScribeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('cache/resolve/{method}/{size}/{path}', [ImageController::class, 'thumbnail'])->where('path', '.*');

$prefix = config('scribe.laravel.docs_url', '/newdoc');
$middleware = config('scribe.laravel.middleware', []);

Route::middleware($middleware)->group(function () use ($prefix) {
    Route::get($prefix, [ScribeController::class, 'webpage'])->name('scribe');
    Route::get("{$prefix}.postman", [ScribeController::class, 'postman'])->name('scribe.postman');
    Route::get("{$prefix}.openapi", [ScribeController::class, 'openapi'])->name('scribe.openapi');
});
