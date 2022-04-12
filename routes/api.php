<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\TokenController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CmsController;
use App\Http\Controllers\Api\EntityController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [ApiController::class, 'home'])->name('api.index');
Route::get('/application', [CmsController::class, 'application'])->name('api.application');
Route::get('/navigation', [CmsController::class, 'navigation'])->name('api.navigation');
Route::post('submission/send', [SubmissionController::class, 'send'])->name('api.submissions.send');

/*
 * Entities routes
 */
Route::get('/search', [EntityController::class, 'search'])->name('api.entities.search');
Route::prefix('entities')->group(function () {
    Route::get('/enums', [EntityController::class, 'enums'])->name('api.entities.enums');
    Route::get('/count', [EntityController::class, 'count'])->name('api.entities.count');
    Route::get('/latest', [EntityController::class, 'latest'])->name('api.entities.latest');
    Route::get('/selection', [EntityController::class, 'selection'])->name('api.entities.selection');
    Route::get('/related/{author_slug}/{book_slug}', [EntityController::class, 'related'])->name('api.entities.related');
    Route::get('/reviews/{entity}/{entity_id}', [EntityController::class, 'reviews'])->name('api.entities.reviews');
});

/*
 * CMS routes
 */
Route::prefix('cms')->group(function () {
    Route::get('/home-page', [CmsController::class, 'home'])->name('api.cms.home-page');
});

/*
 * Authors routes
 */
Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('api.authors.index');
    Route::get('/{author_slug}', [AuthorController::class, 'show'])->name('api.authors.show');
    Route::get('/books/{author_slug}', [AuthorController::class, 'books'])->name('api.authors.show.books');
    Route::get('/series/{author_slug}', [AuthorController::class, 'series'])->name('api.authors.show.series');
});

/*
 * Books routes
 */
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('api.books.index');
    Route::get('/{author_slug}/{book_slug}', [BookController::class, 'show'])->name('api.books.show');
});

/*
 * Series routes
 */
Route::prefix('series')->group(function () {
    Route::get('/', [SerieController::class, 'index'])->name('api.series.index');
    Route::get('/{author_slug}/{serie_slug}', [SerieController::class, 'show'])->name('api.series.show');
    Route::get('/books/{author_slug}/{serie_slug}', [SerieController::class, 'books'])->name('api.series.show.books');
});

/*
 * Reviews routes
 */
Route::prefix('reviews')->group(function () {
    Route::get('/{model}/{slug}', [ReviewController::class, 'index'])->name('api.reviews.index');
});

/*
 * Tags routes
 */
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('api.tags.index');
    Route::get('/character', [TagController::class, 'character'])->name('api.tags.character');
    Route::get('/{tag_slug}', [TagController::class, 'show'])->name('api.tags.show');
    Route::get('/books/{tag_slug}', [TagController::class, 'books'])->name('api.tags.show.books');
});

/*
 * Publishers routes
 */
Route::prefix('publishers')->group(function () {
    Route::get('/', [PublisherController::class, 'index'])->name('api.publishers.index');
    Route::get('/{publisher_slug}', [PublisherController::class, 'show'])->name('api.publishers.show');
    Route::get('/books/{publisher_slug}', [PublisherController::class, 'books'])->name('api.publishers.show.books');
});

/*
 * Lang routes
 */
Route::prefix('languages')->group(function () {
    Route::get('/', [LanguageController::class, 'index'])->name('api.languages.index');
    Route::get('/{language_slug}', [LanguageController::class, 'show'])->name('api.languages.show');
});

/*
 * Users routes
 */
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('api.users.index');
    Route::get('/{user_slug}', [UserController::class, 'show'])->name('api.users.show');
    Route::get('/reviews/{user_slug}', [UserController::class, 'reviews'])->name('api.users.reviews');
    Route::get('/favorites/{user_slug}', [UserController::class, 'favorites'])->name('api.users.favorites');
});

/**
 * Auth routes.
 */
// Route::post('/login', [LoginController::class, 'authenticate'])->name('api.auth.login');
// Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('api.auth.login');
// Route::post('/register', [RegisterController::class, 'store'])->name('api.auth.store');
// Route::post('/password/forgot', [PasswordController::class, 'forgot'])->name('api.auth.password.forgot');
// Route::post('/password/reset', [PasswordController::class, 'reset'])->name('api.auth.password.reset');

/*
 * Users features routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    /**
     * Logout route.
     */
    // Route::post('/logout', [LoginController::class, 'logout'])->name('api.auth.logout');
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('api.auth.logout');

    /*
     * Favorites routes
     */
    Route::prefix('favorites')->group(function () {
        Route::get('/{user:id}', [FavoriteController::class, 'user'])->name('api.favorites.user');
        Route::post('/toggle/{model}/{slug}', [FavoriteController::class, 'toggle'])->name('api.favorites.toggle');
    });

    /*
     * Reviews routes
     */
    Route::prefix('reviews')->group(function () {
        Route::get('/{user:id}', [ReviewController::class, 'user'])->name('api.reviews.user');
        Route::post('/store/{model}/{slug}', [ReviewController::class, 'store'])->name('api.reviews.store');
        Route::post('/edit/{book:slug}', [ReviewController::class, 'edit'])->name('api.reviews.edit');
        Route::post('/update/{book:slug}', [ReviewController::class, 'update'])->name('api.reviews.update');
        Route::post('/destroy/{book:slug}', [ReviewController::class, 'destroy'])->name('api.reviews.destroy');
    });

    /*
     * User routes
     */
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'sanctum'])->name('api.profile');
        Route::post('/update', [ProfileController::class, 'update'])->name('api.profile.update');
        Route::post('/delete', [ProfileController::class, 'delete'])->name('api.profile.delete');
        Route::get('/delete/avatar', [ProfileController::class, 'deleteAvatar'])->name('api.profile.delete.avatar');
    });
    Route::post('/password/update', [PasswordController::class, 'update'])->name('api.password.update');
});

Route::middleware(['api'])->group(function () {
    Route::post('/login', [LoginController::class, 'authenticate'])->name('api.login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('api.logout');
    Route::post('/login/token', [TokenController::class, 'authenticate'])->name('api.login.token');
    Route::post('/logout/token', [TokenController::class, 'logout'])->name('api.logout.token');

    Route::post('/register', [RegisterController::class, 'store'])->name('api.register');

    Route::middleware(['auth:user'])->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('api.user');
    });
});
