<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CountController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\CommandController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\SubmissionController;

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

/*
 * Books routes
 */
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');
Route::get('/books/{author:slug}/{book:slug}', [BookController::class, 'show'])->name('api.books.show');
Route::get('/books/related/{author:slug}/{book:slug}', [BookController::class, 'related'])->name('api.books.related');

/*
 * Series routes
 */
Route::get('/series', [SerieController::class, 'index'])->name('api.series.index');
Route::get('/series/{author:slug}/{serie:slug}', [SerieController::class, 'show'])->name('api.series.show');
Route::get('/series/books/{author:slug}/{serie:slug}', [SerieController::class, 'books'])->name('api.series.show.books');
Route::get('/series/books/{volume}/{author:slug}/{serie:slug}', [SerieController::class, 'current'])->name('api.series.current');

/*
 * Authors routes
 */
Route::get('/authors', [AuthorController::class, 'index'])->name('api.authors.index');
Route::get('/authors/{author:slug}', [AuthorController::class, 'show'])->name('api.authors.show');
Route::get('/authors/books/{author:slug}', [AuthorController::class, 'books'])->name('api.authors.show.books');
Route::get('/authors/series/{author:slug}', [AuthorController::class, 'series'])->name('api.authors.show.series');

/*
 * Count routes
 */
Route::get('/count', [CountController::class, 'count'])->name('api.count');

/*
 * Search routes
 */
Route::get('/search', [SearchController::class, 'index'])->name('api.search.index');
Route::get('/search/books', [SearchController::class, 'books'])->name('api.search.books');
Route::get('/search/authors', [SearchController::class, 'authors'])->name('api.search.authors');
Route::get('/search/series', [SearchController::class, 'series'])->name('api.search.series');
Route::get('/search/advanced', [SearchController::class, 'advanced'])->name('api.search.advanced');

/*
 * Download routes
 */
Route::get('/download/book/{author:slug}/{book:slug}', [DownloadController::class, 'book'])->name('api.download.book');
Route::get('/download/serie/{author:slug}/{serie:slug}', [DownloadController::class, 'serie'])->name('api.download.serie');
Route::get('/download/author/{author:slug}', [DownloadController::class, 'author'])->name('api.download.author');

/*
 * Last entities routes
 */
Route::get('/books/latest', [BookController::class, 'latest'])->name('api.books.latest');
Route::get('/books/selection', [BookController::class, 'selection'])->name('api.books.selection');

/*
 * Submissions routes
 */
Route::post('submission', [SubmissionController::class, 'send'])->name('api.submission.send');

/*
 * Comments routes
 */
Route::get('/comments/by-user/{user:id}', [CommentController::class, 'byUser'])->name('api.comments.by-user');
Route::get('/comments/{model}/{slug}', [CommentController::class, 'index'])->name('api.comments.index');

Route::get('/users', [UserController::class, 'users'])->name('api.users');

/*
 * Tags routes
 */
Route::get('/tags', [TagController::class, 'index'])->name('api.tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('api.tags.show');
Route::get('/tags/books/{tag}', [TagController::class, 'books'])->name('api.tags.show.books');

/* Publishers routes */
Route::get('/publishers', [PublisherController::class, 'index'])->name('api.publishers.index');
Route::get('/publishers/{publisher:slug}', [PublisherController::class, 'show'])->name('api.publishers.show');
Route::get('/publishers/books/{publisher:slug}', [PublisherController::class, 'books'])->name('api.publishers.show.books');

/*
 * Lang routes
 */
Route::get('/languages', [LanguageController::class, 'index'])->name('api.languages.index');

/*
 * Users features routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    /*
     * Favorites routes
     */
    Route::get('/favorites/by-user/{user:id}', [FavoriteController::class, 'byUser'])->name('api.favorites.by-user');
    Route::post('/favorites/toggle/{model}/{slug}', [FavoriteController::class, 'toggle'])->name('api.favorites.toggle');

    /*
     * Comments routes
     */
    Route::post('/comments/store/{model}/{slug}', [CommentController::class, 'store'])->name('api.comments.store');
    Route::post('/comments/edit/{book:slug}', [CommentController::class, 'edit'])->name('api.comments.edit');
    Route::post('/comments/update/{book:slug}', [CommentController::class, 'update'])->name('api.comments.update');
    Route::post('/comments/destroy/{book:slug}', [CommentController::class, 'destroy'])->name('api.comments.destroy');

    /*
     * Commands routes
     */
    Route::get('/commands/update-books', [CommandController::class, 'updateBooks'])->name('api.commands.update-books');

    /*
     * User routes
     */
    Route::get('/user', [UserController::class, 'sanctum'])->name('api.user');
    Route::post('/user/update', [UserController::class, 'update'])->name('api.user.update');
    Route::post('/user/update-password', [UserController::class, 'updatePassword'])->name('api.user.update-password');
    Route::get('/user/delete/avatar', [UserController::class, 'deleteAvatar'])->name('api.user.delete.avatar');
});
