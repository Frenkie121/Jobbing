<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{EmailVerificationController, LoginController, RegisterController, ResetPasswordController};

Route::controller(LoginController::class)->group(function(){
    Route::get('login', 'login')->middleware('guest')->name('login');
    Route::post('login', 'authenticate')->middleware('guest')->name('login');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('guest')->controller(RegisterController::class)->group(function(){
    Route::get('register', 'registerView')->name('register');
    Route::post('register', 'register')->name('register');
});

Route::prefix('email')->name('verification.')->controller(EmailVerificationController::class)->group(function(){
    Route::get('/verify/{id}/{hash}', 'verify')->middleware(['auth', 'signed'])->name('verify');

    Route::get('/verify', 'emailVerifyView')->middleware('auth')->name('notice');

    Route::post('/verification-notification', 'resendVerificationLink')->middleware(['auth', 'throttle:6,1'])->name('send');

    Route::get('resend-link', 'resend')->middleware('auth')->name('resend');
});

Route::name('password.')->middleware('guest')->controller(ResetPasswordController::class)->group(function(){
    Route::get('/forgot-password', 'forgotPassword')->name('request');

    Route::post('/forgot-password', 'handleEmail')->name('email');

    Route::get('/reset-password/{token}', 'resetPassword')->name('reset');

    Route::post('/reset-password', 'updatePassword')->name('update');
});