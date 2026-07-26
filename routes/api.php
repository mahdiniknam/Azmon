<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// GET لیست کاربران
Route::get('/users', [UserController::class, 'index']);

Route::get('/countries',[CountryController::class,'index']);

Route::prefix('auth')->group(function () {

    // ثبت نام
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

    // ورود
    Route::post('/login', [AuthController::class, 'login']);

    // فراموشی پسورد
    Route::post('/forgot-password/send-otp', [AuthController::class, 'sendForgotPasswordOtp']);
    Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyForgotPasswordOtp']);
    Route::post('/forgot-password/reset', [AuthController::class, 'resetPassword']);
});
