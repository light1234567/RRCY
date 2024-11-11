<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;

// Redirect root to login
Route::get('/', fn() => redirect()->route('login'));

// Authenticated Routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/cicl', fn() => Inertia::render('CICL'))->name('cicl');


    Route::middleware(\App\Http\Middleware\CheckAdminRole::class)->group(function () {
        Route::get('/user', fn() => Inertia::render('User'))->name('user');
    });

    Route::middleware(\App\Http\Middleware\CheckRole::class)->group(function () {
        Route::get('/new', fn() => Inertia::render('NewClient'))->name('new');
    });

 

    Route::get('/logs', fn() => Inertia::render('Logs'))->name('logs');

    // MainTab and Case pages with dynamic IDs
    Route::get('/maintab/{id}', fn($id) => Inertia::render('MainTab', ['id' => $id]))->name('maintab');
    Route::get('/case/{id}', fn($id) => Inertia::render('Case', ['id' => $id]))->name('case');
});

// OTP Verification Routes
Route::get('/verify-otp', [OtpVerificationController::class, 'showVerifyForm'])->name('verify.otp');
Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [OtpVerificationController::class, 'resendOtp'])->name('resend.otp');

// Login Route that triggers OTP
Route::post('/login', [OtpVerificationController::class, 'loginWithOtp'])->middleware(['guest'])->name('login');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Location-based Routes
Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/citymunis/{provincePsgc}', [LocationController::class, 'getCityMunis']);
Route::get('/barangays/{cityMuniPsgc}', [LocationController::class, 'getBarangays']);

// Logout Route
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
