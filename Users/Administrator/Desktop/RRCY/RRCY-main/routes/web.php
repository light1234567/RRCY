<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
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
 
 Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route for the main edit page
    Route::get('/edit', function () {
        return Inertia::render('Edit', [
            
        ]);
    })->name('edit');

   
});