<?php

use Illuminate\Support\Facades\Route;

Route::prefix('libraries')->group(function () {
    Route::get('/{library:slug}/{book:slug}', [\App\Http\Controllers\App\BookController::class, 'show'])->name('books.show');
});

// Route::get('health', \Spatie\Health\Http\Controllers\HealthCheckResultsController::class);
