<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Opds\OpdsController;
use App\Http\Controllers\Wiki\WikiController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\Catalog\BookController;
use App\Http\Controllers\Catalog\SerieController;
use App\Http\Controllers\Catalog\AuthorController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Webreader\WebreaderController;
use Knuckles\Scribe\Http\Controller as ScribeController;
use App\Http\Controllers\Opds\BookController as OpdsBookController;
use App\Http\Controllers\Auth\AuthenticatedSessionControllerOverride;
use App\Http\Controllers\Opds\SerieController as OpdsSerieController;
use App\Http\Controllers\Opds\AuthorController as OpdsAuthorController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin'       => Route::has('login'),
//         'canRegister'    => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion'     => PHP_VERSION,
//     ]);
// });
Route::get('/', [NavigationController::class, 'welcome'])->name('welcome');
// Route::get('/welcome', [NavigationController::class, 'welcome'])->name('welcome');



$prefix = config('scribe.laravel.docs_url', '/docs');
$middleware = config('scribe.laravel.middleware', []);

Route::middleware($middleware)
    ->group(function () use ($prefix) {
        Route::get($prefix, [ScribeController::class, 'webpage'])->name('scribe');
    });

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin'       => Route::has('login'),
            'canRegister'    => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion'     => PHP_VERSION,
        ]);
    })->name('admin');
    // override fortify
    // Route::post('/login', [AuthenticatedSessionControllerOverride::class, 'store'])->name('admin.auth.login');
    // Route::post('/logout', [AuthenticatedSessionControllerOverride::class, 'destroy'])->name('admin.auth.logout');
    //
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Route::get('cache/resolve/{method}/{size}/{path}', [ImageController::class, 'thumbnail'])->where('path', '.*');

/*
 * opds routes
 */
Route::prefix('catalog')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/search', [CatalogController::class, 'search'])->name('catalog.search');

    // Route::get('/books', [OpdsBookController::class, 'index'])->name('catalog.books');
    Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('catalog.books.show');

    Route::get('/series', [SerieController::class, 'index'])->name('catalog.series');
    Route::get('/series/{author}/{serie}', [SerieController::class, 'show'])->name('catalog.series.show');

    Route::get('/authors', [AuthorController::class, 'index'])->name('catalog.authors');
    Route::get('/authors/{character}', [AuthorController::class, 'character'])->name('catalog.authors.character');
    Route::get('/authors/{character}/{author}', [AuthorController::class, 'show'])->name('catalog.authors.show');
});

Route::get('/opds', [OpdsController::class, 'index'])->name('opds.index');

Route::prefix('opds/{version}')->group(function () {
    Route::get('/', [OpdsController::class, 'feed'])->name('opds.feed');

    Route::get('/books', [OpdsBookController::class, 'index'])->name('opds.books');
    Route::get('/books/{author}/{book}', [OpdsBookController::class, 'show'])->name('opds.books.show');

    Route::get('/series', [OpdsSerieController::class, 'index'])->name('opds.series');
    Route::get('/series/{author}/{serie}', [OpdsSerieController::class, 'show'])->name('opds.series.show');

    Route::get('/authors', [OpdsAuthorController::class, 'index'])->name('opds.authors');
    Route::get('/authors/{author}', [OpdsAuthorController::class, 'show'])->name('opds.authors.show');
});

/*
 * Wiki routes
 */
Route::prefix('wiki')->group(function () {
    Route::get('/{page?}', [WikiController::class, 'index'])->name('wiki.index');
});

/*
 * Web reader routes
 */
Route::get('/webreader', [WebreaderController::class, 'index'])->name('webreader.index');
Route::get('/webreader/{author:slug}/{book:slug}', [WebreaderController::class, 'cover'])->name('webreader.cover');
Route::get('/webreader/{author:slug}/{book:slug}/{page}', [WebreaderController::class, 'read'])->name('webreader.page');
