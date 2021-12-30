<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthenticationController;
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
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;

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
    Route::get('/{author:slug}/{book:slug}', [BookController::class, 'show'])->name('api.books.show');
    Route::get('/related/{author:slug}/{book:slug}', [BookController::class, 'related'])->name('api.books.related');
    Route::get('/latest', [BookController::class, 'latest'])->name('api.books.latest');
    Route::get('/selection', [BookController::class, 'selection'])->name('api.books.selection');
});

/*
 * Series routes
 */
Route::prefix('/series')->group(function () {
    Route::get('/', [SerieController::class, 'index'])->name('api.series.index');
    Route::get('/{author:slug}/{serie:slug}', [SerieController::class, 'show'])->name('api.series.show');
    Route::get('/books/{author:slug}/{serie:slug}', [SerieController::class, 'books'])->name('api.series.show.books');
    Route::get('/books/{volume}/{author:slug}/{serie:slug}', [SerieController::class, 'current'])->name('api.series.current');
});

/*
 * Authors routes
 */
Route::prefix('/authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('api.authors.index');
    Route::get('/{author:slug}', [AuthorController::class, 'show'])->name('api.authors.show');
    Route::get('/books/{author:slug}', [AuthorController::class, 'books'])->name('api.authors.show.books');
    Route::get('/series/{author:slug}', [AuthorController::class, 'series'])->name('api.authors.show.series');
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
    Route::get('/book/{author:slug}/{book:slug}', [DownloadController::class, 'book'])->name('api.download.book');
    Route::get('/serie/{author:slug}/{serie:slug}', [DownloadController::class, 'serie'])->name('api.download.serie');
    Route::get('/author/{author:slug}', [DownloadController::class, 'author'])->name('api.download.author');
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
    Route::get('/{publisher:slug}', [PublisherController::class, 'show'])->name('api.publishers.show');
    Route::get('/books/{publisher:slug}', [PublisherController::class, 'books'])->name('api.publishers.show.books');
});

/*
 * Lang routes
 */
Route::prefix('/languages')->group(function () {
    Route::get('/', [LanguageController::class, 'index'])->name('api.languages.index');
    Route::get('/{language:slug}', [LanguageController::class, 'show'])->name('api.languages.show');
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
Route::post('/register', [RegisteredUserController::class, 'store'])->name('api.auth.register');
Route::prefix('/auth')->group(function () {
    // Route::post('/register', [AuthenticationController::class, 'register'])->name('api.auth.register');
    // Route::post('/login', [AuthenticationController::class, 'login'])->name('api.auth.login');
    // Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('api.auth.forgot-password');
    // Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('api.auth.reset-password');

    /**
     * Laravel Sanctum routes.
     */
    // Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('api.auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
    // Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
});

/*
 * Users features routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    /**
     * Logout route.
     */
    Route::prefix('/auth')->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('api.auth.logout');
        // Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    });

    /*
     * Favorites routes
     */
    Route::prefix('/favorites')->group(function () {
        Route::get('/{user:id}', [FavoriteController::class, 'user'])->name('api.favorites.user');
        Route::post('/toggle/{model}/{slug}', [FavoriteController::class, 'toggle'])->name('api.favorites.toggle');
    });

    /*
     * Comments routes
     */
    Route::prefix('/comments')->group(function () {
        Route::get('/{user:id}', [CommentController::class, 'user'])->name('api.comments.user');
        Route::post('/store/{model}/{slug}', [CommentController::class, 'store'])->name('api.comments.store');
        Route::post('/edit/{book:slug}', [CommentController::class, 'edit'])->name('api.comments.edit');
        Route::post('/update/{book:slug}', [CommentController::class, 'update'])->name('api.comments.update');
        Route::post('/destroy/{book:slug}', [CommentController::class, 'destroy'])->name('api.comments.destroy');
    });

    /*
     * Commands routes
     */
    Route::get('/commands/update-books', [CommandController::class, 'updateBooks'])->name('api.commands.update-books');

    /*
     * User routes
     */
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'sanctum'])->name('api.profile');
        Route::post('/update', [ProfileController::class, 'update'])->name('api.profile.update');
        Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('api.profile.update-password');
        Route::get('/delete/avatar', [ProfileController::class, 'deleteAvatar'])->name('api.profile.delete.avatar');
    });
});

// Route::get('/register', [RegisteredUserController::class, 'create'])->name('api.auth.register');
// Route::post('/register', [RegisteredUserController::class, 'store'])->name('api.auth.register.post');

// Route::prefix('auth')->group(function () {
    // Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('api.auth.forgot-password');
    // Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('api.auth.forgot-password.post');

    // Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('api.auth.reset-password');
    // Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('api.auth.reset-password.post');
//     Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])->name('api.auth.two-factor-challenge');
//     Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])->name('api.auth.two-factor-challenge.post');

//     Route::middleware(['auth:sanctum'])->group(function () {
//         Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('api.auth.confirm-password');
//         Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])->name('api.auth.confirm-password.post');
//         Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])->name('api.auth.confirmed-password-status');
//         Route::put('/user/password', [PasswordController::class, 'update'])->name('api.auth.password-controller');

//         Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])->name('api.auth.profile-information');

//         Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])->name('api.auth.two-factor-authentication');
//         Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->name('api.auth.two-factor-authentication.post');

//         Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])->name('api.auth.two-factor-qr-code');
//         Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])->name('api.auth.recovery-code');
//         Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])->name('api.auth.recovery-code.post');
//     });
// });

// Route::fallback(function () {
//     Route::any('{any}', function () {
//         return response()->json([
//             'status'    => false,
//             'message'   => 'Page Not Found.',
//         ], 404);
//     })->where('any', '.*');
// });
