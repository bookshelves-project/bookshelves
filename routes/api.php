<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\AuthorController;

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

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/series', [SerieController::class, 'index'])->name('series.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');

Route::get('/books/count', [BookController::class, 'count'])->name('books.count');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::get('/series/count', [SerieController::class, 'count'])->name('series.count');
Route::get('/authors/count', [AuthorController::class, 'count'])->name('authors.count');

Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/download/{author}/{book}', [BookController::class, 'download'])->name('books.download');
Route::get('/series/{serie}', [SerieController::class, 'show'])->name('series.show');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
