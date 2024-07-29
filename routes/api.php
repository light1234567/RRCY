<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Import the UserController with the correct namespace
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ClientController;


Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
Route::get('/clients', [ClientController::class, 'index']);

Route::post('/admission', [AdmissionController::class, 'store']);



// Define the route to get the user role
Route::middleware('auth:sanctum')->get('/user-role', [UserController::class, 'getUserRole']);
