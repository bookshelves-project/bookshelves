<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Auth\AuthenticatedSessionControllerOverride;
use App\Http\Controllers\Features\Catalog\AuthorController;
use App\Http\Controllers\Features\Catalog\BookController;
use App\Http\Controllers\Features\Catalog\CatalogController;
use App\Http\Controllers\Features\Catalog\SerieController;
use App\Http\Controllers\Features\FeaturesController;
use App\Http\Controllers\Features\Opds\AuthorController as OpdsAuthorController;
use App\Http\Controllers\Features\Opds\BookController as OpdsBookController;
use App\Http\Controllers\Features\Opds\OpdsController;
use App\Http\Controllers\Features\Opds\SerieController as OpdsSerieController;
use App\Http\Controllers\Features\Webreader\WebreaderController;
use App\Http\Controllers\Features\Wiki\DevelopmentController;
use App\Http\Controllers\NavigationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
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

Route::get('/', FeaturesController::class)->name('index');
Route::get('/license', [FeaturesController::class, 'license'])->name('license');

// Route::get('/', [NavigationController::class, 'welcome'])->name('welcome');

// // Route::get('cache/resolve/{method}/{size}/{path}', [ImageController::class, 'thumbnail'])->where('path', '.*');

Route::prefix('features')->group(function () {
//     Route::get('/', [NavigationController::class, 'welcome'])->name('features');

    Route::prefix('catalog')->group(function () {
        Route::get('/', [CatalogController::class, 'index'])->name('features.catalog.index');
        Route::get('/search', [CatalogController::class, 'search'])->name('features.catalog.search');

        Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('features.catalog.books.show');

        Route::get('/series', [SerieController::class, 'index'])->name('features.catalog.series');
        Route::get('/series/{character}', [SerieController::class, 'character'])->name('features.catalog.series.character');
        Route::get('/series/{author}/{serie}', [SerieController::class, 'show'])->name('features.catalog.series.show');

        Route::get('/authors', [AuthorController::class, 'index'])->name('features.catalog.authors');
        Route::get('/authors/{character}', [AuthorController::class, 'character'])->name('features.catalog.authors.character');
        Route::get('/authors/{character}/{author}', [AuthorController::class, 'show'])->name('features.catalog.authors.show');
    });

    Route::prefix('opds')->group(function () {
        Route::get('/', [OpdsController::class, 'index'])->name('features.opds.index');

        Route::prefix('{version}')->group(function () {
            Route::get('/', [OpdsController::class, 'feed'])->name('features.opds.feed');

            // Route::get('/books', [OpdsBookController::class, 'index'])->name('features.opds.books');
            Route::get('/books/{author}/{book}', [OpdsBookController::class, 'show'])->name('features.opds.books.show');

            Route::get('/series', [OpdsSerieController::class, 'index'])->name('features.opds.series');
            Route::get('/series/{author}/{serie}', [OpdsSerieController::class, 'show'])->name('features.opds.series.show');

            Route::get('/authors', [OpdsAuthorController::class, 'index'])->name('features.opds.authors');
            Route::get('/authors/{author}', [OpdsAuthorController::class, 'show'])->name('features.opds.authors.show');
        });
    });

    Route::prefix('webreader')->group(function () {
        Route::get('/', [WebreaderController::class, 'index'])->name('features.webreader.index');
        Route::get('/{author:slug}/{book:slug}/{page?}', [WebreaderController::class, 'reader'])->name('features.webreader.reader');
    });

    Route::prefix('development')->group(function () {
        Route::get('/{page?}', [DevelopmentController::class, 'index'])->name('features.development.index');
    });
});

$prefix = config('scribe.laravel.docs_url', '/docs');
$middleware = config('scribe.laravel.middleware', []);

Route::middleware($middleware)->group(function () use ($prefix) {
    Route::get($prefix, [ScribeController::class, 'webpage'])->name('scribe');
    Route::get("{$prefix}.postman", [ScribeController::class, 'postman'])->name('scribe.postman');
    Route::get("{$prefix}.openapi", [ScribeController::class, 'openapi'])->name('scribe.openapi');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'login'])->name('admin.login');
    // Route::get('/', function () {
    //     return Inertia::render('auth/login', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //     ]);
    // })->name('admin');
//     // override fortify
//     // Route::post('/login', [AuthenticatedSessionControllerOverride::class, 'store'])->name('admin.auth.login');
//     // Route::post('/logout', [AuthenticatedSessionControllerOverride::class, 'destroy'])->name('admin.auth.logout');
//     //
    Route::middleware(['auth:admins'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::prefix('cms')->group(function () {
            Route::get('/home', [CmsController::class, 'home'])->name('admin.cms.home');
        });
    });
});
