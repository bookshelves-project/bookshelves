<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\CmsController;
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
use App\Http\Controllers\NavigationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Knuckles\Scribe\Http\Controller as ScribeController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

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

// Route::get('/', [NavigationController::class, 'welcome'])->name('welcome');

// // Route::get('cache/resolve/{method}/{size}/{path}', [ImageController::class, 'thumbnail'])->where('path', '.*');

Route::prefix('features')->group(function () {
    Route::get('/', FeaturesController::class)->name('features');
    Route::get('/license', [FeaturesController::class, 'license'])->name('features.license');

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
});

$prefix = config('scribe.laravel.docs_url', '/docs');
$middleware = config('scribe.laravel.middleware', []);

Route::middleware($middleware)->group(function () use ($prefix) {
    Route::get($prefix, [ScribeController::class, 'webpage'])->name('scribe');
    Route::get("{$prefix}.postman", [ScribeController::class, 'postman'])->name('scribe.postman');
    Route::get("{$prefix}.openapi", [ScribeController::class, 'openapi'])->name('scribe.openapi');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('admin');
    Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    // Route::get('/', function () {
    //     return Inertia::render('auth/login', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //     ]);
    // })->name('admin');
    // Route::middleware(['auth:admins'])->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        //     Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    //     Route::prefix('cms')->group(function () {
    //         Route::get('/home', [CmsController::class, 'home'])->name('admin.cms.home');
    //     });
    });

    Route::prefix('auth')->group(function () {
        // Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        //     ->middleware(['guest', 'throttle:login'])
        //     ->name('admin.auth.login')
        // ;
        // Route::post('/login', [AuthController::class, 'authenticate'])->name('admin.auth.login');

        // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        //     ->name('logout')
        //     ;

        // Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        //     ->middleware(['guest'])
        //     ->name('password.email')
        //     ;

        // Route::post('/reset-password', [NewPasswordController::class, 'store'])
        //     ->middleware(['guest'])
        //     ->name('password.update')
        // ;

        // Route::post('/register', [RegisteredUserController::class, 'store'])
        //     ->middleware(['guest'])
        //     ->name('register')
        // ;

        // Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
        //     ->middleware(['auth'])
        //     ->name('user-profile-information.update')
        // ;

        // Route::put('/user/password', [PasswordController::class, 'update'])
        //     ->middleware(['auth'])
        //     ->name('user-password.update')
        // ;

        // Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        //     ->middleware(['auth'])
        //     ->name('password.confirm')
        // ;

        // Route::delete('/user', [AuthController::class, 'destroy'])
        //     ->middleware(['auth'])
        //     ->name('current-user.destroy')
        //     ;
    });
});
