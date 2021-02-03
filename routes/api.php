<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\SearchController;

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
Route::get('/books/download/{author}/{book}', [BookController::class, 'download'])->name('books.download');
Route::get('/series/download/{serie}', [SerieController::class, 'download'])->name('series.download');
Route::get('/authors/download/{author}', [AuthorController::class, 'download'])->name('authors.download');

/*
 * Misc routes
 */
Route::get('/books/no-cover', [BookController::class, 'no_cover'])->name('books.no-cover');
