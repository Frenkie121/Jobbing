<?php

use App\Http\Controllers\Front\{JobController, MainController};
use App\Http\Controllers\Front\Customer\JobsController;
use App\Http\Controllers\Front\Freelance\{ProfileController};
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
Route::get('jobs/create/preview', [JobController::class, 'preview'])->name('jobs.preview');
Route::post('jobs/create/preview', [JobController::class, 'submit'])->name('jobs.submit');

Route::prefix('categories')->controller(MainController::class)->group(function(){
    Route::get('', 'categories')->name('categories');
    Route::get('{subCategory:slug}', 'category')->name('category');
});


// Freelance
Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function(){
    Route::get('', 'index')->name('index');
    Route::patch('update', 'update')->name('update');
});

// Customer
Route::prefix('jobs')->name('customer.')->controller()->group(function(){
    Route::get('dashboard', [JobsController::class, 'index'])->name('index');
    
});

// Jobs CRUD
Route::resource('jobs', JobController::class);

// Authentication
require __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';

// FALLBACK
Route::fallback(fn() => redirect()->route('home'));