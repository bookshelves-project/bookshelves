<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CmsController;
use App\Http\Controllers\Api\CommandController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CountController;
use App\Http\Controllers\Api\DownloadController;
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

Route::get('/', [ApiController::class, 'apiV1'])->name('api.v1');

Route::get('/enums', [EnumController::class, 'index'])->name('api.v1.enums.index');

/*
 * CMS routes
 */
Route::prefix('cms')->group(function () {
    Route::get('/', [CmsController::class, 'index'])->name('api.v1.cms.index');
    Route::get('/initialization', [CmsController::class, 'initialization'])->name('api.v1.cms.initialization');
    Route::get('/application', [CmsController::class, 'application'])->name('api.v1.cms.application');
    Route::get('/home-page', [CmsController::class, 'home'])->name('api.v1.cms.home-page');
});

/*
 * Authors routes
 */
Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('api.v1.authors.index');
    Route::get('/{author_slug}', [AuthorController::class, 'show'])->name('api.v1.authors.show');
    Route::get('/books/{author_slug}', [AuthorController::class, 'books'])->name('api.v1.authors.show.books');
    Route::get('/series/{author_slug}', [AuthorController::class, 'series'])->name('api.v1.authors.show.series');
});

/*
 * Books routes
 */
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('api.v1.books.index');
    Route::get('/{author_slug}/{book_slug}', [BookController::class, 'show'])->name('api.v1.books.show');
    Route::get('/related/{author_slug}/{book_slug}', [BookController::class, 'related'])->name('api.v1.books.related');
    Route::get('/latest', [BookController::class, 'latest'])->name('api.v1.books.latest');
    Route::get('/selection', [BookController::class, 'selection'])->name('api.v1.books.selection');
});

/*
 * Series routes
 */
Route::prefix('series')->group(function () {
    Route::get('/', [SerieController::class, 'index'])->name('api.v1.series.index');
    Route::get('/{author_slug}/{serie_slug}', [SerieController::class, 'show'])->name('api.v1.series.show');
    Route::get('/books/{author_slug}/{serie_slug}', [SerieController::class, 'books'])->name('api.v1.series.show.books');
    Route::get('/books/{volume}/{author_slug}/{serie_slug}', [SerieController::class, 'current'])->name('api.v1.series.current');
});

/*
 * Count routes
 */
Route::get('/count', [CountController::class, 'count'])->name('api.v1.count');

/*
 * Search routes
 */
Route::prefix('search')->group(function () {
    Route::get('/', [SearchController::class, 'index'])->name('api.v1.search.index');
    // Route::get('/books', [SearchController::class, 'books'])->name('api.v1.search.books');
    // Route::get('/authors', [SearchController::class, 'authors'])->name('api.v1.search.authors');
    // Route::get('/series', [SearchController::class, 'series'])->name('api.v1.search.series');
    // Route::get('/advanced', [SearchController::class, 'advanced'])->name('api.v1.search.advanced');
});

/*
 * Download routes
 */
Route::prefix('download')->group(function () {
    Route::get('/book/{author_slug}/{book_slug}', [DownloadController::class, 'book'])->name('api.v1.download.book');
    Route::get('/serie/{author_slug}/{serie_slug}', [DownloadController::class, 'serie'])->name('api.v1.download.serie');
    Route::get('/author/{author_slug}', [DownloadController::class, 'author'])->name('api.v1.download.author');
});

/*
 * Submissions routes
 */
Route::post('submission', [SubmissionController::class, 'send'])->name('api.v1.submission.send');

/*
 * Comments routes
 */
Route::prefix('comments')->group(function () {
    Route::get('/{model}/{slug}', [CommentController::class, 'index'])->name('api.v1.comments.index');
});

/*
 * Users routes
 */
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'users'])->name('api.v1.users');
    Route::get('/genders', [UserController::class, 'genders'])->name('api.v1.genders');
});

/*
 * Tags routes
 */
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('api.v1.tags.index');
    Route::get('/{tag_slug}', [TagController::class, 'show'])->name('api.v1.tags.show');
    Route::get('/books/{tag_slug}', [TagController::class, 'books'])->name('api.v1.tags.show.books');
});

/*
 * Publishers routes
 */
Route::prefix('publishers')->group(function () {
    Route::get('/', [PublisherController::class, 'index'])->name('api.v1.publishers.index');
    Route::get('/{publisher_slug}', [PublisherController::class, 'show'])->name('api.v1.publishers.show');
    Route::get('/books/{publisher_slug}', [PublisherController::class, 'books'])->name('api.v1.publishers.show.books');
});

/*
 * Lang routes
 */
Route::prefix('languages')->group(function () {
    Route::get('/', [LanguageController::class, 'index'])->name('api.v1.languages.index');
    Route::get('/{language_slug}', [LanguageController::class, 'show'])->name('api.v1.languages.show');
});

/*
 * Comments routes
 */
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('api.v1.users.index');
    Route::get('/{slug}', [UserController::class, 'show'])->name('api.v1.users.show');
    Route::get('/comments/{slug}', [UserController::class, 'comments'])->name('api.v1.users.comments');
    Route::get('/favorites/{slug}', [UserController::class, 'favorites'])->name('api.v1.users.favorites');
});

/**
 * Auth routes.
 */
// Route::post('/login', [LoginController::class, 'authenticate'])->name('api.v1.auth.login');
// Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('api.v1.auth.login');
// Route::post('/register', [RegisterController::class, 'store'])->name('api.v1.auth.store');
// Route::post('/password/forgot', [PasswordController::class, 'forgot'])->name('api.v1.auth.password.forgot');
// Route::post('/password/reset', [PasswordController::class, 'reset'])->name('api.v1.auth.password.reset');

/*
 * Users features routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    /**
     * Logout route.
     */
    // Route::post('/logout', [LoginController::class, 'logout'])->name('api.v1.auth.logout');
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('api.v1.auth.logout');

    /*
     * Favorites routes
     */
    Route::prefix('favorites')->group(function () {
        Route::get('/{user:id}', [FavoriteController::class, 'user'])->name('api.v1.favorites.user');
        Route::post('/toggle/{model}/{slug}', [FavoriteController::class, 'toggle'])->name('api.v1.favorites.toggle');
    });

    /*
     * Comments routes
     */
    Route::prefix('comments')->group(function () {
        Route::get('/{user:id}', [CommentController::class, 'user'])->name('api.v1.comments.user');
        Route::post('/store/{model}/{slug}', [CommentController::class, 'store'])->name('api.v1.comments.store');
        Route::post('/edit/{book:slug}', [CommentController::class, 'edit'])->name('api.v1.comments.edit');
        Route::post('/update/{book:slug}', [CommentController::class, 'update'])->name('api.v1.comments.update');
        Route::post('/destroy/{book:slug}', [CommentController::class, 'destroy'])->name('api.v1.comments.destroy');
    });

    /*
     * Commands routes
     */
    Route::get('/commands/update-books', [CommandController::class, 'updateBooks'])->name('api.v1.commands.update-books');

    /*
     * User routes
     */
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'sanctum'])->name('api.v1.profile');
        Route::post('/update', [ProfileController::class, 'update'])->name('api.v1.profile.update');
        Route::post('/delete', [ProfileController::class, 'delete'])->name('api.v1.profile.delete');
        Route::get('/delete/avatar', [ProfileController::class, 'deleteAvatar'])->name('api.v1.profile.delete.avatar');
    });
    Route::post('/password/update', [PasswordController::class, 'update'])->name('api.v1.password.update');
});

Route::post('/login', [LoginController::class, 'loginSession'])->name('api.login');
Route::post('/login/token', [LoginController::class, 'loginToken'])->name('api.login.token');
Route::post('/logout', [LoginController::class, 'logoutSession'])->name('api.logout');
Route::post('/logout/token', [LoginController::class, 'logoutToken'])->name('api.logout.token');
Route::post('/register', [RegisterController::class, 'store'])->name('api.register');
Route::get('/user', [AuthController::class, 'user'])->middleware(['auth:sanctum'])->name('api.user');
