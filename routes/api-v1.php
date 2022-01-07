<?php

use App\Http\Controllers\Api\ApiController;
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

Route::get('/', [ApiController::class, 'index'])->name('api.index');
Route::get('/app-init', [ApiController::class, 'init'])->name('api.init');

Route::get('/enums', [EnumController::class, 'index'])->name('api.enums.index');

/*
 * CMS routes
 */
Route::prefix('/cms')->group(function () {
    Route::get('/', [CmsController::class, 'index'])->name('api.cms.index');
    Route::get('/application', [CmsController::class, 'application'])->name('api.cms.application');
    Route::get('/home-page', [CmsController::class, 'home'])->name('api.cms.home-page');
});

/*
 * Books routes
 */
Route::prefix('/books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('api.books.index');
    Route::get('/{author}/{book}', [BookController::class, 'show'])->name('api.books.show');
    Route::get('/related/{author}/{book}', [BookController::class, 'related'])->name('api.books.related');
    Route::get('/latest', [BookController::class, 'latest'])->name('api.books.latest');
    Route::get('/selection', [BookController::class, 'selection'])->name('api.books.selection');
});

/*
 * Series routes
 */
Route::prefix('/series')->group(function () {
    Route::get('/', [SerieController::class, 'index'])->name('api.series.index');
    Route::get('/{author}/{serie}', [SerieController::class, 'show'])->name('api.series.show');
    Route::get('/books/{author}/{serie}', [SerieController::class, 'books'])->name('api.series.show.books');
    Route::get('/books/{volume}/{author}/{serie}', [SerieController::class, 'current'])->name('api.series.current');
});

/*
 * Authors routes
 */
Route::prefix('/authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('api.authors.index');
    Route::get('/{author}', [AuthorController::class, 'show'])->name('api.authors.show');
    Route::get('/books/{author}', [AuthorController::class, 'books'])->name('api.authors.show.books');
    Route::get('/series/{author}', [AuthorController::class, 'series'])->name('api.authors.show.series');
});

/*
 * Count routes
 */
Route::get('/count', [CountController::class, 'count'])->name('api.count');

/*
 * Search routes
 */
Route::prefix('/search')->group(function () {
    Route::get('/', [SearchController::class, 'index'])->name('api.search.index');
    Route::get('/books', [SearchController::class, 'books'])->name('api.search.books');
    Route::get('/authors', [SearchController::class, 'authors'])->name('api.search.authors');
    Route::get('/series', [SearchController::class, 'series'])->name('api.search.series');
    Route::get('/advanced', [SearchController::class, 'advanced'])->name('api.search.advanced');
});

/*
 * Download routes
 */
Route::prefix('/download')->group(function () {
    Route::get('/book/{author}/{book}', [DownloadController::class, 'book'])->name('api.download.book');
    Route::get('/serie/{author}/{serie}', [DownloadController::class, 'serie'])->name('api.download.serie');
    Route::get('/author/{author}', [DownloadController::class, 'author'])->name('api.download.author');
});

/*
 * Submissions routes
 */
Route::post('submission', [SubmissionController::class, 'send'])->name('api.submission.send');

/*
 * Comments routes
 */
Route::prefix('/comments')->group(function () {
    Route::get('/{model}/{slug}', [CommentController::class, 'index'])->name('api.comments.index');
});

/*
 * Users routes
 */
Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'users'])->name('api.users');
    Route::get('/genders', [UserController::class, 'genders'])->name('api.genders');
});

/*
 * Tags routes
 */
Route::prefix('/tags')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('api.tags.index');
    Route::get('/{tag}', [TagController::class, 'show'])->name('api.tags.show');
    Route::get('/books/{tag}', [TagController::class, 'books'])->name('api.tags.show.books');
});

/*
 * Publishers routes
 */
Route::prefix('/publishers')->group(function () {
    Route::get('/', [PublisherController::class, 'index'])->name('api.publishers.index');
    Route::get('/{publisher}', [PublisherController::class, 'show'])->name('api.publishers.show');
    Route::get('/books/{publisher}', [PublisherController::class, 'books'])->name('api.publishers.show.books');
});

/*
 * Lang routes
 */
Route::prefix('/languages')->group(function () {
    Route::get('/', [LanguageController::class, 'index'])->name('api.languages.index');
    Route::get('/{language}', [LanguageController::class, 'show'])->name('api.languages.show');
});

/*
 * Comments routes
 */
Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('api.users.index');
    Route::get('/{slug}', [UserController::class, 'show'])->name('api.users.show');
    Route::get('/comments/{slug}', [UserController::class, 'comments'])->name('api.users.comments');
    Route::get('/favorites/{slug}', [UserController::class, 'favorites'])->name('api.users.favorites');
});

/**
 * Auth routes.
 */
Route::post('/login', [LoginController::class, 'authenticate'])->name('api.auth.login');
Route::post('/register', [RegisterController::class, 'store'])->name('api.auth.store');
Route::post('/password/forgot', [PasswordController::class, 'forgot'])->name('api.auth.password.forgot');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('api.auth.password.reset');

// /*
//  * Users features routes
//  */
// Route::middleware(['auth:users'])->group(function () {
//     /**
//      * Logout route.
//      */
//     Route::post('/logout', [LoginController::class, 'logout'])->name('api.auth.logout');

//     /*
//      * Favorites routes
//      */
//     Route::prefix('/favorites')->group(function () {
//         Route::get('/{user:id}', [FavoriteController::class, 'user'])->name('api.favorites.user');
//         Route::post('/toggle/{model}/{slug}', [FavoriteController::class, 'toggle'])->name('api.favorites.toggle');
//     });

//     /*
//      * Comments routes
//      */
//     Route::prefix('/comments')->group(function () {
//         Route::get('/{user:id}', [CommentController::class, 'user'])->name('api.comments.user');
//         Route::post('/store/{model}/{slug}', [CommentController::class, 'store'])->name('api.comments.store');
//         Route::post('/edit/{book:slug}', [CommentController::class, 'edit'])->name('api.comments.edit');
//         Route::post('/update/{book:slug}', [CommentController::class, 'update'])->name('api.comments.update');
//         Route::post('/destroy/{book:slug}', [CommentController::class, 'destroy'])->name('api.comments.destroy');
//     });

//     /*
//      * Commands routes
//      */
//     Route::get('/commands/update-books', [CommandController::class, 'updateBooks'])->name('api.commands.update-books');

//     /*
//      * User routes
//      */
//     Route::prefix('/profile')->group(function () {
//         Route::get('/', [ProfileController::class, 'sanctum'])->name('api.profile');
//         Route::post('/update', [ProfileController::class, 'update'])->name('api.profile.update');
//         Route::post('/delete', [ProfileController::class, 'delete'])->name('api.profile.delete');
//         Route::get('/delete/avatar', [ProfileController::class, 'deleteAvatar'])->name('api.profile.delete.avatar');
//     });
//     Route::post('/password/update', [PasswordController::class, 'update'])->name('api.password.update');
// });
