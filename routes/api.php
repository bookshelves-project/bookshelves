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
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CountController;
use App\Http\Controllers\Api\EnumController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PublisherController;
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

Route::get('enums', [EnumController::class, 'index'])->name('api.enums.index');
Route::post('send/submission', [SubmissionController::class, 'send'])->name('api.submission.send');
Route::get('count', [CountController::class, 'count'])->name('api.count');
Route::get('search', [SearchController::class, 'index'])->name('api.search.index');

/*
 * CMS routes
 */
Route::prefix('cms')->group(function () {
    Route::get('/', [CmsController::class, 'index'])->name('api.cms.index');
    Route::get('/initialization', [CmsController::class, 'initialization'])->name('api.cms.initialization');
    Route::get('/application', [CmsController::class, 'application'])->name('api.cms.application');
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
    Route::get('/download/{author_slug}/{format?}', [AuthorController::class, 'download'])->name('api.authors.download');
});

/*
 * Books routes
 */
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('api.books.index');
    Route::get('/{author_slug}/{book_slug}', [BookController::class, 'show'])->name('api.books.show');
    Route::get('/related/{author_slug}/{book_slug}', [BookController::class, 'related'])->name('api.books.related');
    Route::get('/latest', [BookController::class, 'latest'])->name('api.books.latest');
    Route::get('/selection', [BookController::class, 'selection'])->name('api.books.selection');
    Route::get('/download/{author_slug}/{book_slug}/{format?}', [BookController::class, 'download'])->name('api.books.download');
});

/*
 * Series routes
 */
Route::prefix('series')->group(function () {
    Route::get('/', [SerieController::class, 'index'])->name('api.series.index');
    Route::get('/{author_slug}/{serie_slug}', [SerieController::class, 'show'])->name('api.series.show');
    Route::get('/books/{author_slug}/{serie_slug}', [SerieController::class, 'books'])->name('api.series.show.books');
    Route::get('/books/{volume}/{author_slug}/{serie_slug}', [SerieController::class, 'current'])->name('api.series.current');
    Route::get('/download/{author_slug}/{serie_slug}/{format?}', [SerieController::class, 'download'])->name('api.series.download');
});

/*
 * Comments routes
 */
Route::prefix('comments')->group(function () {
    Route::get('/{model}/{slug}', [CommentController::class, 'index'])->name('api.comments.index');
});

/*
 * Tags routes
 */
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('api.tags.index');
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
    Route::get('/comments/{user_slug}', [UserController::class, 'comments'])->name('api.users.comments');
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
     * Comments routes
     */
    Route::prefix('comments')->group(function () {
        Route::get('/{user:id}', [CommentController::class, 'user'])->name('api.comments.user');
        Route::post('/store/{model}/{slug}', [CommentController::class, 'store'])->name('api.comments.store');
        Route::post('/edit/{book:slug}', [CommentController::class, 'edit'])->name('api.comments.edit');
        Route::post('/update/{book:slug}', [CommentController::class, 'update'])->name('api.comments.update');
        Route::post('/destroy/{book:slug}', [CommentController::class, 'destroy'])->name('api.comments.destroy');
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
