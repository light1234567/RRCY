<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
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

// Route for the main edit page with an id parameter
Route::get('/maintab/{id}', function ($id) {
    return Inertia::render('MainTab', ['id' => $id]);
})->name('maintab');
