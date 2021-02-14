<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Build\DependencyController;

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

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

/*
 * List routes
 */
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/series', [SerieController::class, 'index'])->name('series.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');

/*
 * Count routes
 */
Route::get('/books/count', [BookController::class, 'count'])->name('books.count');
Route::get('/series/count', [SerieController::class, 'count'])->name('series.count');
Route::get('/authors/count', [AuthorController::class, 'count'])->name('authors.count');

/*
 * Search routes
 */
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search-book', [SearchController::class, 'byBook'])->name('search.book');
Route::get('/search-author', [SearchController::class, 'byAuthor'])->name('search.author');
Route::get('/search-serie', [SearchController::class, 'bySerie'])->name('search.serie');

/*
 * Details routes
 */
Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/series/{serie}', [SerieController::class, 'show'])->name('series.show');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

/*
 * Download routes
 */
Route::get('/download/book/{author}/{book}', [DownloadController::class, 'book'])->name('download.book');
Route::get('/download/serie/{serie}', [DownloadController::class, 'serie'])->name('download.serie');
Route::get('/download/author/{author}', [DownloadController::class, 'author'])->name('download.author');

/*
 * Last entities routes
 */
Route::get('/books/latest', [BookController::class, 'latest'])->name('books.latest');

/*
 * Misc routes
 */
Route::get('/books/count-langs', [BookController::class, 'count_langs'])->name('books.count-langs');
Route::post('contact', [ContactController::class, 'send'])->name('contact.send');

/*
 * Dependencies routes
 */
Route::get('/dependencies', [DependencyController::class, 'index'])->name('dependencies.index');
// Route::get('/dependencies/{slashData?}', [DependencyController::class, 'show'])->name('dependencies.show')->where('slashData', '(.*)');

/*
 * Comments routes
 */
Route::get('/comments/by-user/{user}', [CommentController::class, 'byUser'])->name('comments.by-user');
Route::get('/comments/{model}/{slug}', [CommentController::class, 'index'])->name('comments.index');

Route::get('/favorites/by-user/{user}', [FavoriteController::class, 'byUser'])->name('favorites.by-user');

/*
 * Users features routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    /*
     * Favorites routes
     */
    Route::post('/favorites/toggle/{model}/{slug}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    /*
     * Comments routes
     */
    Route::post('/comments/store/{model}/{slug}', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/edit/{book}', [CommentController::class, 'edit'])->name('comments.edit');
    Route::post('/comments/update/{book}', [CommentController::class, 'update'])->name('comments.update');
    Route::post('/comments/destroy/{book}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
