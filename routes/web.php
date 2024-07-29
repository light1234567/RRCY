<?php

use App\Http\Controllers\AdmissionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ClientController;

Route::get('/clients', [ClientController::class, 'index']);

Route::get('/clients/{id}', [ClientController::class, 'show'])->name('ClientDetails');
Route::post('/admission', [AdmissionController::class, 'store']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/cicl', function () {
        return Inertia::render('CICL');
    })->name('cicl');

    Route::get('/new', function () {
        return Inertia::render('NewClient');
    })->name('new');
});

