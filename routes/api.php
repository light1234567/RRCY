<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Import the UserController with the correct namespace

// Define the route to get the user role
Route::middleware('auth:sanctum')->get('/user-role', [UserController::class, 'getUserRole']);
