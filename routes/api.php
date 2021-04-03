<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\CommandController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\DependencyController;
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

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::get('/', [ApiController::class, 'index'])->name('api.index');

/*
 * List routes
 */
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');
Route::get('/series', [SerieController::class, 'index'])->name('api.series.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('api.authors.index');

/*
 * Count routes
 */
Route::get('/books/count', [BookController::class, 'count'])->name('api.books.count');
Route::get('/books/count-langs', [BookController::class, 'count_langs'])->name('api.books.count-langs');
Route::get('/series/count', [SerieController::class, 'count'])->name('api.series.count');
Route::get('/authors/count', [AuthorController::class, 'count'])->name('api.authors.count');

/*
 * Search routes
 */
Route::get('/search', [SearchController::class, 'index'])->name('api.search.index');
Route::get('/search-book', [SearchController::class, 'byBook'])->name('api.search.book');
Route::get('/search-author', [SearchController::class, 'byAuthor'])->name('api.search.author');
Route::get('/search-serie', [SearchController::class, 'bySerie'])->name('api.search.serie');

/*
 * Details routes
 */
Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('api.books.show');
Route::get('/series/{author}/{serie}', [SerieController::class, 'show'])->name('api.series.show');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('api.authors.show');

/*
 * Download routes
 */
Route::get('/download/book/{author}/{book}', [DownloadController::class, 'book'])->name('api.download.book');
Route::get('/download/serie/{author}/{serie}', [DownloadController::class, 'serie'])->name('api.download.serie');
Route::get('/download/author/{author}', [DownloadController::class, 'author'])->name('api.download.author');

/*
 * Last entities routes
 */
Route::get('/books/latest', [BookController::class, 'latest'])->name('api.books.latest');

/*
 * Submissions routes
 */
Route::post('submission', [SubmissionController::class, 'send'])->name('api.submission.send');

/*
 * Dependencies routes
 */
Route::get('/dependencies', [DependencyController::class, 'index'])->name('api.dependencies.index');
// Route::get('/dependencies/{slashData?}', [DependencyController::class, 'show'])->name('api.dependencies.show')->where('slashData', '(.*)');

/*
 * Comments routes
 */
Route::get('/comments/by-user/{user}', [CommentController::class, 'byUser'])->name('api.comments.by-user');
Route::get('/comments/{model}/{slug}', [CommentController::class, 'index'])->name('api.comments.index');

Route::get('/favorites/by-user/{user}', [FavoriteController::class, 'byUser'])->name('api.favorites.by-user');

/*
 * Users features routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    /*
     * Favorites routes
     */
    Route::post('/favorites/toggle/{model}/{slug}', [FavoriteController::class, 'toggle'])->name('api.favorites.toggle');

    /*
     * Comments routes
     */
    Route::post('/comments/store/{model}/{slug}', [CommentController::class, 'store'])->name('api.comments.store');
    Route::post('/comments/edit/{book}', [CommentController::class, 'edit'])->name('api.comments.edit');
    Route::post('/comments/update/{book}', [CommentController::class, 'update'])->name('api.comments.update');
    Route::post('/comments/destroy/{book}', [CommentController::class, 'destroy'])->name('api.comments.destroy');

    /*
     * Commands routes
     */
    Route::get('/commands/update-books', [CommandController::class, 'updateBooks'])->name('api.commands.update-books');

    Route::get('/user', [UserController::class, 'sanctum'])->name('api.user');
});
