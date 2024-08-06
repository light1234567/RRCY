<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Import the UserController with the correct namespace
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\InterventionPlanController;
use App\Http\Controllers\InterventionPlanItemController;



Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']); // Ensure this route is defined
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
Route::post('/admission', [AdmissionController::class, 'store']);
Route::post('/save-admission', [AdmissionController::class, 'saveForm']);
Route::get('/clients-data/{id}', [AdmissionController::class, 'getAllData']);
Route::get('/checklist/{id}', [ChecklistController::class, 'index']);
Route::post('/save-checklist', [ChecklistController::class, 'store']);

Route::get('/intervention-plans', [InterventionPlanController::class, 'index']);
Route::get('/intervention-plans/{id}', [InterventionPlanController::class, 'show']);
Route::post('/intervention-plans', [InterventionPlanController::class, 'store']);
Route::put('/intervention-plans/{id}', [InterventionPlanController::class, 'update']);
Route::delete('/intervention-plans/{id}', [InterventionPlanController::class, 'destroy']);

Route::get('/intervention-plan-items', [InterventionPlanItemController::class, 'index']);
Route::get('/intervention-plan-items/{id}', [InterventionPlanItemController::class, 'show']);
Route::post('/intervention-plan-items', [InterventionPlanItemController::class, 'store']);
Route::put('/intervention-plan-items/{id}', [InterventionPlanItemController::class, 'update']);
Route::delete('/intervention-plan-items/{id}', [InterventionPlanItemController::class, 'destroy']);


// Define the route to get the user role
Route::middleware('auth:sanctum')->get('/user-role', [UserController::class, 'getUserRole']);

