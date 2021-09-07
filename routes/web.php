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
use App\Http\Controllers\Roadmap\RoadmapController;
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

Route::get('/', [NavigationController::class, 'welcome'])->name('welcome');

// Route::get('cache/resolve/{method}/{size}/{path}', [ImageController::class, 'thumbnail'])->where('path', '.*');

Route::prefix('features')->group(function () {
    Route::get('/', [NavigationController::class, 'welcome'])->name('features');

    Route::prefix('catalog')->group(function () {
        Route::get('/', [CatalogController::class, 'index'])->name('features.catalog.index');
        Route::get('/search', [CatalogController::class, 'search'])->name('features.catalog.search');

        Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('features.catalog.books.show');

        Route::get('/series', [SerieController::class, 'index'])->name('features.catalog.series');
        Route::get('/series/{author}/{serie}', [SerieController::class, 'show'])->name('features.catalog.series.show');

        Route::get('/authors', [AuthorController::class, 'index'])->name('features.catalog.authors');
        Route::get('/authors/{character}', [AuthorController::class, 'character'])->name('features.catalog.authors.character');
        Route::get('/authors/{character}/{author}', [AuthorController::class, 'show'])->name('features.catalog.authors.show');
    });

    Route::prefix('opds')->group(function () {
        Route::get('/', [OpdsController::class, 'index'])->name('features.opds.index');

        Route::prefix('{version}')->group(function () {
            Route::get('/', [OpdsController::class, 'feed'])->name('features.opds.feed');

            Route::get('/books', [OpdsBookController::class, 'index'])->name('features.opds.books');
            Route::get('/books/{author}/{book}', [OpdsBookController::class, 'show'])->name('features.opds.books.show');

            Route::get('/series', [OpdsSerieController::class, 'index'])->name('features.opds.series');
            Route::get('/series/{author}/{serie}', [OpdsSerieController::class, 'show'])->name('features.opds.series.show');

            Route::get('/authors', [OpdsAuthorController::class, 'index'])->name('features.opds.authors');
            Route::get('/authors/{author}', [OpdsAuthorController::class, 'show'])->name('features.opds.authors.show');
        });
    });


    Route::prefix('webreader')->group(function () {
        Route::get('/', [WebreaderController::class, 'index'])->name('features.webreader.index');
        Route::get('/{author:slug}/{book:slug}', [WebreaderController::class, 'cover'])->name('features.webreader.cover');
        Route::get('/{author:slug}/{book:slug}/{page}', [WebreaderController::class, 'read'])->name('features.webreader.page');
    });

    Route::prefix('wiki')->group(function () {
        Route::get('/{page?}', [WikiController::class, 'index'])->name('features.wiki.index');
    });

    Route::prefix('roadmap')->group(function () {
        Route::get('/', [RoadmapController::class, 'index'])->name('features.roadmap.index');
    });
});

$prefix = config('scribe.laravel.docs_url', '/docs');
$middleware = config('scribe.laravel.middleware', []);

Route::middleware($middleware)->group(function () use ($prefix) {
    Route::get($prefix, [ScribeController::class, 'webpage'])->name('scribe');
    Route::get("$prefix.postman", [ScribeController::class, 'postman'])->name('scribe.postman');
    Route::get("$prefix.openapi", [ScribeController::class, 'openapi'])->name('scribe.openapi');
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
