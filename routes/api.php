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
use App\Http\Controllers\IndicatorOfSocialFunctioningController;
use App\Http\Controllers\PsychologicalInterventionPlanController;
use App\Http\Controllers\InitialPsychologicalAssessmentController;
use App\Http\Controllers\CiclProgressNoteController;
use App\Http\Controllers\AnecdotalReportController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Controllers\MonthlyInventoryController;
use App\Http\Controllers\CiclSessionController;
use App\Http\Controllers\SwappingFormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NursingCareServiceController;
use App\Http\Controllers\PerformanceObservationReportController;
use App\Http\Controllers\TrainingNeedsAssessmentController;
use App\Http\Controllers\LearnerAcademicBehavioralFormController;
use App\Http\Controllers\LearnerAssessmentFormController;
use App\Http\Controllers\FileController;


Route::post('/check-email', [UserController::class, 'checkEmail']);
Route::post('/validate-password', [UserController::class, 'validatePassword']);
Route::post('/user-role', [UserController::class, 'getUserRole']);
Route::middleware('auth:sanctum')->get('/user-role', [UserController::class, 'getUserRole']);

// Admin Routes
Route::get('/users', [AdminController::class, 'index']);
Route::get('/users/{id}', [AdminController::class, 'show']);
Route::delete('/users/{id}', [AdminController::class, 'destroy']);
Route::patch('/users/{id}/verify', [AdminController::class, 'verify']);

// Client Routes
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

// Admission Routes
Route::post('/admission', [AdmissionController::class, 'store']);
Route::get('/admissions/client/{client_id}', [AdmissionController::class, 'getAdmissionByClientId']);
Route::get('/clients-data', [AdmissionController::class, 'getAllData']);
Route::post('/save-admission', [AdmissionController::class, 'saveForm']);
Route::get('/clients-data/{id}', [AdmissionController::class, 'getAllData']);
Route::get('/test', [AdmissionController::class, 'getClientsByName']);

// Checklist Routes
Route::get('/checklist/{id}', [ChecklistController::class, 'index']);
Route::post('/save-checklist', [ChecklistController::class, 'store']);

// Intervention Plan Routes
Route::get('/intervention-plans', [InterventionPlanController::class, 'index']);
Route::get('/intervention-plans/{id}', [InterventionPlanController::class, 'show']);
Route::post('/intervention-plans', [InterventionPlanController::class, 'store']);
Route::put('/intervention-plans/{id}', [InterventionPlanController::class, 'update']);
Route::delete('/intervention-plans/{id}', [InterventionPlanController::class, 'destroy']);

// Intervention Plan Item Routes
Route::get('/intervention-plan-items', [InterventionPlanItemController::class, 'index']);
Route::get('/intervention-plan-items/{id}', [InterventionPlanItemController::class, 'show']);
Route::post('/intervention-plan-items', [InterventionPlanItemController::class, 'store']);
Route::put('/intervention-plan-items/{id}', [InterventionPlanItemController::class, 'update']);
Route::delete('/intervention-plan-items/{id}', [InterventionPlanItemController::class, 'destroy']);

// General Intake Sheet Routes
Route::get('/general-intake-sheets', [GeneralIntakeSheetController::class, 'index']);
Route::get('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'show']);
Route::post('/general-intake-sheets', [GeneralIntakeSheetController::class, 'store']);
Route::put('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'update']);
Route::delete('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'destroy']);

// Second Intake Sheet Routes
Route::get('/second-intake-sheets', [SecondIntakeSheetController::class, 'index']);
Route::get('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'show']);
Route::post('/second-intake-sheets', [SecondIntakeSheetController::class, 'store']);
Route::put('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'update']);
Route::delete('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'destroy']);

// Kasabutan Routes
Route::get('/kasabutan', [KasabutanController::class, 'index']);
Route::get('/kasabutan/{id}', [KasabutanController::class, 'show']);
Route::post('/kasabutan', [KasabutanController::class, 'store']);
Route::put('/kasabutan/{id}', [KasabutanController::class, 'update']);
Route::delete('/kasabutan/{id}', [KasabutanController::class, 'destroy']);

// Data Privacy Consent Routes
Route::get('/data-privacy-consent', [DataPrivacyConsentController::class, 'index']);
Route::get('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'show']);
Route::post('/data-privacy-consent', [DataPrivacyConsentController::class, 'store']);
Route::put('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'update']);
Route::delete('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'destroy']);

// Talambuhay Routes
Route::get('/talambuhay', [TalambuhayController::class, 'index']);
Route::get('/talambuhay/{id}', [TalambuhayController::class, 'show']);
Route::post('/talambuhay', [TalambuhayController::class, 'store']);
Route::put('/talambuhay/{id}', [TalambuhayController::class, 'update']);
Route::delete('/talambuhay/{id}', [TalambuhayController::class, 'destroy']);

// Admission Contract Routes
Route::get('/admission-contracts', [AdmissionContractController::class, 'index']);
Route::get('/admission-contracts/{id}', [AdmissionContractController::class, 'show']);
Route::post('/admission-contracts', [AdmissionContractController::class, 'store']);
Route::put('/admission-contracts/{id}', [AdmissionContractController::class, 'update']);
Route::delete('/admission-contracts/{id}', [AdmissionContractController::class, 'destroy']);

// Indicators of Social Functioning Routes
Route::get('/indicators-of-social-functioning', [IndicatorOfSocialFunctioningController::class, 'index']);
Route::get('/indicators-of-social-functioning/{id}', [IndicatorOfSocialFunctioningController::class, 'show']);
Route::post('/indicators-of-social-functioning', [IndicatorOfSocialFunctioningController::class, 'store']);
Route::put('/indicators-of-social-functioning/{id}', [IndicatorOfSocialFunctioningController::class, 'update']);
Route::delete('/indicators-of-social-functioning/{id}', [IndicatorOfSocialFunctioningController::class, 'destroy']);
Route::get('/indicators-of-social-functioning/check/{client_id}/{admission_id}', [IndicatorOfSocialFunctioningController::class, 'checkExisting']);
Route::apiResource('indicators-of-social-functioning', IndicatorOfSocialFunctioningController::class);

//Psychological Intervention Plan Routes
Route::post('/psychological-intervention-plans', [PsychologicalInterventionPlanController::class, 'store']);
Route::get('/psychological-intervention-plans/{id}', [PsychologicalInterventionPlanController::class, 'show']);
Route::put('/psychological-intervention-plans/{id}', [PsychologicalInterventionPlanController::class, 'update']);


//Initial Psychological Assessment Routes
Route::get('/initial-psychological-assessments', [InitialPsychologicalAssessmentController::class, 'index']);
Route::get('/initial-psychological-assessments/{client_id}/{admission_id}', [InitialPsychologicalAssessmentController::class, 'show']);
Route::get('/initial-psychological-assessments/{client_id}', [InitialPsychologicalAssessmentController::class, 'show']);
Route::post('/initial-psychological-assessments', [InitialPsychologicalAssessmentController::class, 'store']);
Route::put('/initial-psychological-assessments/{id}', [InitialPsychologicalAssessmentController::class, 'update']);
Route::delete('/initial-psychological-assessments/{id}', [InitialPsychologicalAssessmentController::class, 'destroy']);

// Cicl Progress Notes Routes
Route::get('/cicl-progress-notes', [CiclProgressNoteController::class, 'index']);
Route::get('/cicl-progress-notes/{client_id}', [CiclProgressNoteController::class, 'show']);
Route::post('/cicl-progress-notes', [CiclProgressNoteController::class, 'store']);
Route::put('/cicl-progress-notes/{client_id}', [CiclProgressNoteController::class, 'update']);
Route::delete('/cicl-progress-notes/{id}', [CiclProgressNoteController::class, 'destroy']);

// Anecdotal Report Routes
Route::get('/anecdotal-reports', [AnecdotalReportController::class, 'index']);
Route::get('/anecdotal-reports/{client_id}', [AnecdotalReportController::class, 'show']);
Route::post('/anecdotal-reports', [AnecdotalReportController::class, 'store']);
Route::put('/anecdotal-reports/{client_id}', [AnecdotalReportController::class, 'update']);
Route::delete('/anecdotal-reports/{id}', [AnecdotalReportController::class, 'destroy']);

// Incident Report Routes
Route::get('/incident-reports', [IncidentReportController::class, 'index']);
Route::get('/incident-reports/{client_id}', [IncidentReportController::class, 'show']);
Route::post('/incident-reports', [IncidentReportController::class, 'store']);
Route::put('/incident-reports/{client_id}', [IncidentReportController::class, 'update']);
Route::delete('/incident-reports/{id}', [IncidentReportController::class, 'destroy']);

//Monthly Inventory Routes
Route::get('monthly-inventories/{client_id}', [MonthlyInventoryController::class, 'show']);
Route::post('monthly-inventories', [MonthlyInventoryController::class, 'store']); // For creating
Route::put('monthly-inventories', [MonthlyInventoryController::class, 'store']); // For updating
Route::delete('monthly-inventories/{id}', [MonthlyInventoryController::class, 'destroy']);

//Cicl Session Routes
Route::get('/cicl-sessions', [CiclSessionController::class, 'index']);
Route::get('/cicl-sessions/{client_id}', [CiclSessionController::class, 'show']);
Route::post('/cicl-sessions', [CiclSessionController::class, 'store']);
Route::put('/cicl-sessions/{client_id}', [CiclSessionController::class, 'update']);
Route::delete('/cicl-sessions/{id}', [CiclSessionController::class, 'destroy']);
Route::put('/cicl-sessions/{id}', [CiclSessionController::class, 'update']);

//Swapping Form Routes
Route::get('/swapping-forms', [SwappingFormController::class, 'index']);
Route::get('/swapping-forms/{client_id}', [SwappingFormController::class, 'show']);
Route::post('/swapping-forms', [SwappingFormController::class, 'store']);
Route::put('/swapping-forms/{client_id}', [SwappingFormController::class, 'update']);
Route::delete('/swapping-forms/{id}', [SwappingFormController::class, 'destroy']);

// Nursing Care Service Routes
Route::get('/nursing-care-services', [NursingCareServiceController::class, 'index']);
Route::get('/nursing-care-services/{id}', [NursingCareServiceController::class, 'show']);
Route::post('/nursing-care-services', [NursingCareServiceController::class, 'storeOrUpdate']);
Route::put('/nursing-care-services/{id}', [NursingCareServiceController::class, 'storeOrUpdate']); // Combined route for store and update
Route::delete('/nursing-care-services/{id}', [NursingCareServiceController::class, 'destroy']);


Route::get('/performance-observation-reports', [PerformanceObservationReportController::class, 'index']);
Route::delete('/performance-observation-reports/{id}', [PerformanceObservationReportController::class, 'destroy']);
Route::get('/performance-observation-reports/{client_id}', [PerformanceObservationReportController::class, 'show']);
Route::post('/performance-observation-reports/{client_id}', [PerformanceObservationReportController::class, 'storeOrUpdate']);


//Training Needs Assessment Routes
Route::get('/training-needs-assessment/{client_id}', [TrainingNeedsAssessmentController::class, 'show']);
Route::put('/training-needs-assessment/{client_id}', [TrainingNeedsAssessmentController::class, 'storeOrUpdate']);


Route::get('/learner-academic-behavioral-forms/{client_id}', [LearnerAcademicBehavioralFormController::class, 'show']);
Route::post('/learner-academic-behavioral-forms', [LearnerAcademicBehavioralFormController::class, 'storeOrUpdate']);


Route::get('/learner-assessment-forms/{client_id}', [LearnerAssessmentFormController::class, 'show']);
Route::post('/learner-assessment-forms', [LearnerAssessmentFormController::class, 'storeOrUpdate']);


// File and Folder Operations with clientId
Route::get('/folders-and-files/{clientId}', [FileController::class, 'index']);
Route::post('/create-folder', [FileController::class, 'createFolder']);
Route::post('/upload', [FileController::class, 'uploadFile']);
Route::post('/move-file', [FileController::class, 'moveFile']);
Route::post('/delete-folder', [FileController::class, 'deleteFolder']);
Route::post('/delete-file', [FileController::class, 'deleteFile']);

Route::patch('/users/{id}/toggle-verify', [AdminController::class, 'toggleVerify']);


