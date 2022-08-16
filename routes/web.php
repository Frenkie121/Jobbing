<?php

use App\Http\Controllers\Front\{JobController, MainController};
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainController::class, 'home'])->name('home');

// Jobs
Route::resource('jobs', JobController::class);
Route::get('categories', [MainController::class, 'categories'])->name('categories');
Route::get('categories/{subCategory:slug}', [MainController::class, 'category'])->name('category');


// Authentication
require __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';

// FALLBACK
Route::fallback(fn() => redirect()->route('home'));