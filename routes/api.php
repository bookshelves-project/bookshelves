<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
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
use App\Http\Controllers\Api\Opds\OpdsController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\WebreaderController;
use App\Http\Controllers\Api\Wiki\WikiController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\Api\Catalog\CatalogController;
use App\Http\Controllers\Api\Opds\BookController as OpdsBookController;
use App\Http\Controllers\Api\Opds\SerieController as OpdsSerieController;
use App\Http\Controllers\Api\Opds\AuthorController as OpdsAuthorController;
use App\Http\Controllers\Api\Catalog\BookController as CatalogBookController;
use App\Http\Controllers\Api\Catalog\SerieController as CatalogSerieController;
use App\Http\Controllers\Api\Catalog\AuthorController as CatalogAuthorController;

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

/*
 * opds routes
 */
Route::prefix('catalog')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('api.catalog.index');
    Route::get('/search', [CatalogController::class, 'search'])->name('api.catalog.search');

    // Route::get('/books', [OpdsBookController::class, 'index'])->name('api.catalog.books');
    Route::get('/books/{author}/{book}', [CatalogBookController::class, 'show'])->name('api.catalog.books.show');

    Route::get('/series', [CatalogSerieController::class, 'index'])->name('api.catalog.series');
    Route::get('/series/{author}/{serie}', [CatalogSerieController::class, 'show'])->name('api.catalog.series.show');

    Route::get('/authors', [CatalogAuthorController::class, 'index'])->name('api.catalog.authors');
    Route::get('/authors/{author}', [CatalogAuthorController::class, 'show'])->name('api.catalog.authors.show');
});

Route::get('/opds', [OpdsController::class, 'index'])->name('api.opds.index');

Route::prefix('opds/{version}')->group(function () {
    Route::get('/', [OpdsController::class, 'feed'])->name('api.opds');

    Route::get('/books', [OpdsBookController::class, 'index'])->name('api.opds.books');
    Route::get('/books/{author}/{book}', [OpdsBookController::class, 'show'])->name('api.opds.books.show');

    Route::get('/series', [OpdsSerieController::class, 'index'])->name('api.opds.series');
    Route::get('/series/{author}/{serie}', [OpdsSerieController::class, 'show'])->name('api.opds.series.show');

    Route::get('/authors', [OpdsAuthorController::class, 'index'])->name('api.opds.authors');
    Route::get('/authors/{author}', [OpdsAuthorController::class, 'show'])->name('api.opds.authors.show');
});

/*
 * Wiki routes
 */
Route::prefix('wiki')->group(function () {
    Route::get('/', [WikiController::class, 'index'])->name('api.wiki.index');
});

/*
 * Web reader routes
 */
Route::get('/webreader', [WebreaderController::class, 'index'])->name('api.webreader.index');

/*
 * Books routes
 */
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');
Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('api.books.show');
Route::get('/books/related/{author}/{book}', [BookController::class, 'related'])->name('api.books.related');

/*
 * Series routes
 */
Route::get('/series', [SerieController::class, 'index'])->name('api.series.index');
Route::get('/series/{author}/{serie}', [SerieController::class, 'show'])->name('api.series.show');
Route::get('/series/books/{author}/{serie}', [SerieController::class, 'books'])->name('api.series.show.books');
Route::get('/series/books/{volume}/{author}/{serie}', [SerieController::class, 'showCurrent'])->name('api.series.show-current');

/*
 * Authors routes
 */
Route::get('/authors', [AuthorController::class, 'index'])->name('api.authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('api.authors.show');
Route::get('/authors/books/{author}', [AuthorController::class, 'books'])->name('api.authors.show.books');
Route::get('/authors/series/{author}', [AuthorController::class, 'series'])->name('api.authors.show.series');

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
Route::get('/download/book/{author}/{book}', [DownloadController::class, 'book'])->name('api.download.book');
Route::get('/download/serie/{author}/{serie}', [DownloadController::class, 'serie'])->name('api.download.serie');
Route::get('/download/author/{author}', [DownloadController::class, 'author'])->name('api.download.author');

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
Route::get('/comments/by-user/{user}', [CommentController::class, 'byUser'])->name('api.comments.by-user');
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
Route::get('/publishers/{publisher}', [PublisherController::class, 'show'])->name('api.publishers.show');
Route::get('/publishers/books/{publisher}', [PublisherController::class, 'books'])->name('api.publishers.show.books');

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
    Route::get('/favorites/by-user/{user}', [FavoriteController::class, 'byUser'])->name('api.favorites.by-user');
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

    /*
     * User routes
     */
    Route::get('/user', [UserController::class, 'sanctum'])->name('api.user');
    Route::post('/user/update', [UserController::class, 'update'])->name('api.user.update');
    Route::post('/user/update-password', [UserController::class, 'updatePassword'])->name('api.user.update-password');
    Route::get('/user/delete/avatar', [UserController::class, 'deleteAvatar'])->name('api.user.delete.avatar');
});
