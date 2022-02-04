<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Front\Catalog\AuthorController as CatalogAuthorController;
use App\Http\Controllers\Front\Catalog\BookController as CatalogBookController;
use App\Http\Controllers\Front\Catalog\CatalogController;
use App\Http\Controllers\Front\Catalog\SerieController as CatalogSerieController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\Opds\AuthorController as OpdsAuthorController;
use App\Http\Controllers\Front\Opds\BookController as OpdsBookController;
use App\Http\Controllers\Front\Opds\OpdsController;
use App\Http\Controllers\Front\Opds\SerieController as OpdsSerieController;
use App\Http\Controllers\Front\Webreader\WebreaderController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['web'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::prefix('features')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('front.home');
        Route::get('/license', [HomeController::class, 'license'])->name('front.license');
        Route::get('/configuration', [HomeController::class, 'configuration'])->name('front.configuration')->middleware('debug.only');

        Route::prefix('catalog')->group(function () {
            Route::get('/', [CatalogController::class, 'index'])->name('front.catalog.index');
            Route::get('/search', [CatalogController::class, 'search'])->name('front.catalog.search');

            Route::get('/books/{author}/{book}', [CatalogBookController::class, 'show'])->name('front.catalog.books.show');

            Route::get('/series', [CatalogSerieController::class, 'index'])->name('front.catalog.series');
            Route::get('/series/{character}', [CatalogSerieController::class, 'character'])->name('front.catalog.series.character');
            Route::get('/series/{author}/{serie}', [CatalogSerieController::class, 'show'])->name('front.catalog.series.show');

            Route::get('/authors', [CatalogAuthorController::class, 'index'])->name('front.catalog.authors');
            Route::get('/authors/{character}', [CatalogAuthorController::class, 'character'])->name('front.catalog.authors.character');
            Route::get('/authors/{character}/{author}', [CatalogAuthorController::class, 'show'])->name('front.catalog.authors.show');
        });

        Route::prefix('opds')->group(function () {
            Route::get('/', [OpdsController::class, 'index'])->name('front.opds.index');

            Route::prefix('{version}')->group(function () {
                Route::get('/', [OpdsController::class, 'feed'])->name('front.opds.feed');

                // Route::get('/books', [OpdsBookController::class, 'index'])->name('front.opds.books');
                Route::get('/books/{author}/{book}', [OpdsBookController::class, 'show'])->name('front.opds.books.show');

                Route::get('/series', [OpdsSerieController::class, 'index'])->name('front.opds.series');
                Route::get('/series/{author}/{serie}', [OpdsSerieController::class, 'show'])->name('front.opds.series.show');

                Route::get('/authors', [OpdsAuthorController::class, 'index'])->name('front.opds.authors');
                Route::get('/authors/{author}', [OpdsAuthorController::class, 'show'])->name('front.opds.authors.show');
            });
        });

        Route::prefix('webreader')->group(function () {
            Route::get('/', [WebreaderController::class, 'index'])->name('front.webreader.index');
            Route::get('/{author:slug}/{book:slug}/{page?}', [WebreaderController::class, 'reader'])->name('front.webreader.reader');
        });
    });
});

Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('login', [AdminAuthController::class, 'login'])->name('admin.login')->middleware('guest');
    Route::get('forgot-password', [AdminAuthController::class, 'requestPasswordResetLink'])->name('admin.password.request')->middleware('guest');
    Route::get('reset-password/{token}', [AdminAuthController::class, 'resetPassword'])->name('admin.password.reset')->middleware('guest');
    Route::get('register', [AdminAuthController::class, 'register'])->name('admin.register')->middleware('guest');
    Route::get('user/confirm-password', [AdminAuthController::class, 'confirmPassword'])->name('admin.password.confirm')->middleware('auth:sanctum');
    Route::get('user/profile', [AdminAuthController::class, 'show'])->name('admin.profile.show')->middleware('auth:sanctum');
});

Route::prefix('admin')->middleware(['web', 'auth:sanctum', 'can:access-admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'redirect']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users');
        Route::get('create', [UserController::class, 'create'])->name('admin.users.create');
        Route::get('{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::post('{user}/impersonate', [UserController::class, 'impersonate'])->name('admin.users.impersonate');
        Route::post('stop-impersonate', [UserController::class, 'stopImpersonate'])->name('admin.users.stop-impersonate');
        Route::put('{user}', [UserController::class, 'update'])->name('admin.users.update')->middleware('can:modify-user,user');
        Route::patch('{user}/toggle', [UserController::class, 'toggle'])->name('admin.users.toggle')->middleware('can:modify-user,user');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('admin.users.destroy')->middleware('can:modify-user,user');
        Route::delete('/', [UserController::class, 'bulkDestroy'])->name('admin.users.bulk.destroy');
    });

    Route::prefix('post-categories')->group(function () {
        Route::get('/', [PostCategoryController::class, 'index'])->name('admin.post-categories');
    });

    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('admin.books');
        Route::get('create', [BookController::class, 'create'])->name('admin.books.create');
        Route::get('{book}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::post('/', [BookController::class, 'store'])->name('admin.books.store');
        Route::put('{book}', [BookController::class, 'update'])->name('admin.books.update');
        Route::patch('{book}/toggle', [BookController::class, 'toggle'])->name('admin.books.toggle');
        Route::delete('{book}', [BookController::class, 'destroy'])->name('admin.books.destroy');
        Route::delete('/', [BookController::class, 'bulkDestroy'])->name('admin.books.bulk.destroy');
    });

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('admin.posts');
        Route::get('create', [PostController::class, 'create'])->name('admin.posts.create');
        Route::get('{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
        Route::post('/', [PostController::class, 'store'])->name('admin.posts.store');
        Route::put('{post}', [PostController::class, 'update'])->name('admin.posts.update');
        Route::patch('{post}/toggle', [PostController::class, 'toggle'])->name('admin.posts.toggle');
        Route::delete('{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
        Route::delete('/', [PostController::class, 'bulkDestroy'])->name('admin.posts.bulk.destroy');
    });

    Route::get('search/{query?}', [SearchController::class, 'index'])->name('admin.search');

    Route::prefix('tags')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('admin.tags');
    });

    Route::post('/upload', [UploadController::class, 'upload'])->name('admin.upload');
});

// Route::get('/', FeaturesController::class)->name('index');

// // Route::get('/', [NavigationController::class, 'welcome'])->name('welcome');

// // // Route::get('cache/resolve/{method}/{size}/{path}', [ImageController::class, 'thumbnail'])->where('path', '.*');

$prefix = config('scribe.laravel.docs_url', '/docs');
$middleware = config('scribe.laravel.middleware', []);

Route::middleware($middleware)->group(function () use ($prefix) {
    Route::get($prefix, [ScribeController::class, 'webpage'])->name('scribe');
    Route::get("{$prefix}.postman", [ScribeController::class, 'postman'])->name('scribe.postman');
    Route::get("{$prefix}.openapi", [ScribeController::class, 'openapi'])->name('scribe.openapi');
});

// Route::prefix('admin')->group(function () {
//     Route::get('/', [AuthController::class, 'index'])->name('admin');
//     Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
//     // Route::get('/', function () {
//     //     return Inertia::render('auth/login', [
//     //         'canLogin' => Route::has('login'),
//     //         'canRegister' => Route::has('register'),
//     //         'laravelVersion' => Application::VERSION,
//     //         'phpVersion' => PHP_VERSION,
//     //     ]);
//     // })->name('admin');
//     // Route::middleware(['auth:admins'])->group(function () {
//     Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//         Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//         //     Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//     //     Route::prefix('cms')->group(function () {
//     //         Route::get('/home', [CmsController::class, 'home'])->name('admin.cms.home');
//     //     });
//     });

//     Route::prefix('auth')->group(function () {
//         // Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//         //     ->middleware(['guest', 'throttle:login'])
//         //     ->name('admin.auth.login')
//         // ;
//         // Route::post('/login', [AuthController::class, 'authenticate'])->name('admin.auth.login');

//         // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//         //     ->name('logout')
//         //     ;

//         // Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//         //     ->middleware(['guest'])
//         //     ->name('password.email')
//         //     ;

//         // Route::post('/reset-password', [NewPasswordController::class, 'store'])
//         //     ->middleware(['guest'])
//         //     ->name('password.update')
//         // ;

//         // Route::post('/register', [RegisteredUserController::class, 'store'])
//         //     ->middleware(['guest'])
//         //     ->name('register')
//         // ;

//         // Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
//         //     ->middleware(['auth'])
//         //     ->name('user-profile-information.update')
//         // ;

//         // Route::put('/user/password', [PasswordController::class, 'update'])
//         //     ->middleware(['auth'])
//         //     ->name('user-password.update')
//         // ;

//         // Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
//         //     ->middleware(['auth'])
//         //     ->name('password.confirm')
//         // ;

//         // Route::delete('/user', [AuthController::class, 'destroy'])
//         //     ->middleware(['auth'])
//         //     ->name('current-user.destroy')
//         //     ;
//     });
// });
