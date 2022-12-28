<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Customer\JobsController;
use App\Http\Controllers\Front\Freelance\{JobsController as FreelanceJobsController, ProfileController};
use App\Http\Controllers\Front\{ChatController, JobController, MainController};

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

Route::get('jobs/create/preview', [JobController::class, 'preview'])->name('jobs.preview');
Route::post('jobs/create/preview', [JobController::class, 'submit'])->name('jobs.submit');

// Jobs CRUD
Route::resource('jobs', JobController::class);

Route::prefix('categories')->controller(MainController::class)->group(function(){
    Route::get('', 'categories')->name('categories');
    Route::get('{subCategory:slug}/jobs', 'category')->name('category.jobs');
});

// Freelance
Route::prefix('profile')->name('profile.')->middleware(['auth', 'role:Freelance'])->controller(ProfileController::class)->group(function(){
    Route::get('', 'index')->name('index');
    Route::patch('update', 'update')->name('update');
});

Route::middleware(['auth', 'role:Freelance', 'verified'])->name('freelance.')->controller(FreelanceJobsController::class)->group(function(){
    Route::get('dashboard', 'index')->name('index');
    Route::patch('jobs/{job}/apply', 'apply')->name('apply');
    Route::patch('jobs/{job}/cancel', 'cancel')->name('cancel');
    
});

// Customer
Route::middleware(['auth', 'role:Customer'])->name('customer.')->controller(JobsController::class)->group(function(){
    Route::get('my-jobs/dashboard', 'index')->name('index');
    Route::get('my-jobs/{job}/applications', 'showApplications')->name('applications');

    Route::patch('my-jobs/{job}/launch', 'launch')->name('job.launch');

    // APPLICANTS
    Route::patch('my-jobs/{job}/applications/{freelance}/select', 'select')->name('select')->middleware('throttle:2,1');
    
});

Route::get('chat', [ChatController::class, 'index'])->name('job.chat');
Route::post('chat', [ChatController::class, 'store'])->name('job.chat.store');

// Authentication
require __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';

// FALLBACK
Route::fallback(fn() => redirect()->route('home'));