<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\InterventionPlanController;
use App\Http\Controllers\InterventionPlanItemController;
use App\Http\Controllers\GeneralIntakeSheetController;
use App\Http\Controllers\SecondIntakeSheetController;
use App\Http\Controllers\KasabutanController;
use App\Http\Controllers\DataPrivacyConsentController;
use App\Http\Controllers\TalambuhayController;
use App\Http\Controllers\AdmissionContractController;

Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
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

Route::get('/general-intake-sheets', [GeneralIntakeSheetController::class, 'index']);
Route::get('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'show']);
Route::post('/general-intake-sheets', [GeneralIntakeSheetController::class, 'store']);
Route::put('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'update']);
Route::delete('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'destroy']);

Route::get('/second-intake-sheets', [SecondIntakeSheetController::class, 'index']);
Route::get('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'show']);
Route::post('/second-intake-sheets', [SecondIntakeSheetController::class, 'store']);
Route::put('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'update']);
Route::delete('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'destroy']);

Route::get('/kasabutan', [KasabutanController::class, 'index']);
Route::get('/kasabutan/{id}', [KasabutanController::class, 'show']);
Route::post('/kasabutan', [KasabutanController::class, 'store']);
Route::put('/kasabutan/{id}', [KasabutanController::class, 'update']);
Route::delete('/kasabutan/{id}', [KasabutanController::class, 'destroy']);

Route::get('/data-privacy-consent', [DataPrivacyConsentController::class, 'index']);
Route::get('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'show']);
Route::post('/data-privacy-consent', [DataPrivacyConsentController::class, 'store']);
Route::put('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'update']);
Route::delete('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'destroy']);

Route::get('/talambuhay', [TalambuhayController::class, 'index']);
Route::get('/talambuhay/{id}', [TalambuhayController::class, 'show']);
Route::post('/talambuhay', [TalambuhayController::class, 'store']);
Route::put('/talambuhay/{id}', [TalambuhayController::class, 'update']);
Route::delete('/talambuhay/{id}', [TalambuhayController::class, 'destroy']);

Route::get('/admission-contracts', [AdmissionContractController::class, 'index']);
Route::get('/admission-contracts/{id}', [AdmissionContractController::class, 'show']);
Route::post('/admission-contracts', [AdmissionContractController::class, 'store']);
Route::put('/admission-contracts/{id}', [AdmissionContractController::class, 'update']);
Route::delete('/admission-contracts/{id}', [AdmissionContractController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user-role', [UserController::class, 'getUserRole']);
?>
