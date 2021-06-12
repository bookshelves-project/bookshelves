<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CommandController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CountController;
use App\Http\Controllers\Api\DependencyController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\Opds\AuthorController as OpdsAuthorController;
use App\Http\Controllers\Api\Opds\BookController as OpdsBookController;
use App\Http\Controllers\Api\Opds\OpdsController;
use App\Http\Controllers\Api\Opds\SerieController as OpdsSerieController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WebreaderController;
use App\Http\Controllers\Api\Wiki\WikiController;
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

/*
 * opds routes
 */
Route::prefix('opds')->group(function () {
	Route::get('/', [OpdsController::class, 'index'])->name('api.opds.index');
	Route::get('/search', [OpdsController::class, 'search'])->name('api.opds.search');

	// Route::get('/books', [OpdsBookController::class, 'index'])->name('api.opds.books');
	Route::get('/books/{author}/{slug}', [OpdsBookController::class, 'show'])->name('api.opds.books.show');

	Route::get('/series', [OpdsSerieController::class, 'index'])->name('api.opds.series');
	Route::get('/series/{author}/{slug}', [OpdsSerieController::class, 'show'])->name('api.opds.series.show');

	Route::get('/authors', [OpdsAuthorController::class, 'index'])->name('api.opds.authors');
	Route::get('/authors/{slug}', [OpdsAuthorController::class, 'show'])->name('api.opds.authors.show');
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
 * List routes
 */
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');
Route::get('/series', [SerieController::class, 'index'])->name('api.series.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('api.authors.index');

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
 * Details routes
 */
Route::get('/books/{author}/{book}', [BookController::class, 'show'])->name('api.books.show');
Route::get('/books/more/{author}/{slug}', [BookController::class, 'more'])->name('api.books.more');
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
Route::get('/books/selection', [BookController::class, 'selection'])->name('api.books.selection');

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

Route::get('/users', [UserController::class, 'users'])->name('api.users');

/*
 * Tags routes
 */
Route::get('/tags', [TagController::class, 'index'])->name('api.tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('api.tags.show');
Route::get('/tags/book/{author}/{book}', [TagController::class, 'book'])->name('api.tags.book');

/*
 * Genres routes
 */
Route::get('/genres', [GenreController::class, 'index'])->name('api.genres.index');
Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('api.genres.show');

/* Publishers routes */
Route::get('/publishers', [PublisherController::class, 'index'])->name('api.publishers.index');
Route::get('/publishers/{publisher}', [PublisherController::class, 'show'])->name('api.publishers.show');

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
