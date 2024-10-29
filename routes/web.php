<?php

use App\Http\Controllers\App\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('libraries')->group(function () {
    Route::get('/{library:slug}/{book:slug}', [BookController::class, 'show'])->name('books.show');

});
