<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Import the UserController with the correct namespace
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ClientController;


Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']); // Ensure this route is defined
Route::patch('/clients/{id}', [ClientController::class, 'updateStatus']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
Route::post('/admission', [AdmissionController::class, 'store']);
Route::post('/save-admission', [AdmissionController::class, 'saveForm']);
Route::get('/clients-data', [AdmissionController::class, 'getAllData']);


// Define the route to get the user role
Route::middleware('auth:sanctum')->get('/user-role', [UserController::class, 'getUserRole']);