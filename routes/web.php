<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use Knuckles\Scribe\Http\Controller as ScribeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('front.index');
Route::get('/login', fn () => redirect('/admin/login'))->name('login');
