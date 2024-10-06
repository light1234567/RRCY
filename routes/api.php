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
use App\Http\Controllers\CaseManagerController;
use App\Http\Controllers\SHPController;
use App\Http\Controllers\DrnController;
use App\Http\Controllers\CenterHeadController;


Route::post('/check-email', [UserController::class, 'checkEmail']);
Route::post('/validate-password', [UserController::class, 'validatePassword']);
Route::post('/user-role', [UserController::class, 'getUserRole']);
Route::middleware('auth:sanctum')->get('/user-role', [UserController::class, 'getUserRole']);

// Admin Routes
Route::get('/users', [AdminController::class, 'index']);
Route::get('/users/{id}', [AdminController::class, 'show']);
Route::delete('/users/{id}', [AdminController::class, 'destroy']);
Route::patch('/users/{id}/verify', [AdminController::class, 'verify']);
Route::patch('/users/{id}/toggle-verify', [AdminController::class, 'toggleVerify']);

// Client Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
});
// Admission Routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/admission', [AdmissionController::class, 'store']);
    Route::get('/admissions/client/{client_id}', [AdmissionController::class, 'getAdmissionByClientId']);
    Route::get('/clients-data', [AdmissionController::class, 'getAllData']);
    Route::post('/save-admission', [AdmissionController::class, 'saveForm']);
    Route::put('/admission/{id}', [AdmissionController::class, 'saveForm']);
    Route::get('/clients-data/{id}', [AdmissionController::class, 'getAllData']);
    Route::get('/test', [AdmissionController::class, 'getClientsByName']);
    Route::post('/admission', [AdmissionController::class, 'saveForm']); 
    Route::get('/center-head/{client_id}', [AdmissionController::class, 'getCenterHeadName']);
    Route::put('/update-center-head', [AdmissionController::class, 'updateCenterHead']);
    Route::post('/admission/updateClientStatus/{clientId}', [AdmissionController::class, 'updateClientStatus']);
    });

// Checklist Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/checklist/{id}', [ChecklistController::class, 'index']);
Route::post('/save-checklist', [ChecklistController::class, 'store']);
Route::post('/checklist', [ChecklistController::class, 'store']);
});
// Intervention Plan Routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/intervention-plans', [InterventionPlanController::class, 'index']);
    Route::get('/intervention-plans/{id}', [InterventionPlanController::class, 'show']);
    Route::post('/intervention-plans', [InterventionPlanController::class, 'store']);
    Route::put('/intervention-plans/{id}', [InterventionPlanController::class, 'update']);
    Route::delete('/intervention-plans/{id}', [InterventionPlanController::class, 'destroy']);
});
// General Intake Sheet Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/general-intake-sheets', [GeneralIntakeSheetController::class, 'index']);
Route::get('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'show']);
Route::post('/general-intake-sheets', [GeneralIntakeSheetController::class, 'store']);
Route::put('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'update']);
Route::delete('/general-intake-sheets/{id}', [GeneralIntakeSheetController::class, 'destroy']);
});
// Second Intake Sheet Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/second-intake-sheets', [SecondIntakeSheetController::class, 'index']);
Route::get('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'show']);
Route::post('/second-intake-sheets', [SecondIntakeSheetController::class, 'store']);
Route::put('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'update']);
Route::delete('/second-intake-sheets/{id}', [SecondIntakeSheetController::class, 'destroy']);
});

// Kasabutan Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/kasabutan', [KasabutanController::class, 'index']);
Route::get('/kasabutan/{id}', [KasabutanController::class, 'show']);
Route::post('/kasabutan', [KasabutanController::class, 'store']);
Route::put('/kasabutan/{id}', [KasabutanController::class, 'update']);
Route::delete('/kasabutan/{id}', [KasabutanController::class, 'destroy']);
});
// Data Privacy Consent Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/data-privacy-consent', [DataPrivacyConsentController::class, 'index']);
Route::get('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'show']);
Route::post('/data-privacy-consent', [DataPrivacyConsentController::class, 'store']);
Route::put('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'update']);
Route::delete('/data-privacy-consent/{id}', [DataPrivacyConsentController::class, 'destroy']);
});
// Talambuhay Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/talambuhay', [TalambuhayController::class, 'index']);
Route::get('/talambuhay/{id}', [TalambuhayController::class, 'show']);
Route::post('/talambuhay', [TalambuhayController::class, 'store']);
Route::put('/talambuhay/{id}', [TalambuhayController::class, 'update']);
Route::delete('/talambuhay/{id}', [TalambuhayController::class, 'destroy']);
});
// Admission Contract Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/admission-contracts', [AdmissionContractController::class, 'index']);
Route::get('/admission-contracts/{id}', [AdmissionContractController::class, 'show']);
Route::post('/admission-contracts', [AdmissionContractController::class, 'store']);
Route::put('/admission-contracts/{id}', [AdmissionContractController::class, 'update']);
Route::delete('/admission-contracts/{id}', [AdmissionContractController::class, 'destroy']);
});
// Indicators of Social Functioning Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/indicators-of-social-functioning', [IndicatorOfSocialFunctioningController::class, 'index']);
Route::get('/indicators-of-social-functioning/{id}', [IndicatorOfSocialFunctioningController::class, 'show']);
Route::post('/indicators-of-social-functioning', [IndicatorOfSocialFunctioningController::class, 'store']);
Route::put('/indicators-of-social-functioning/{client_id}/{admission_id}', [IndicatorOfSocialFunctioningController::class, 'update']);
Route::delete('/indicators-of-social-functioning/{id}', [IndicatorOfSocialFunctioningController::class, 'destroy']);
Route::get('/indicators-of-social-functioning/check/{client_id}/{admission_id}', [IndicatorOfSocialFunctioningController::class, 'checkExisting']);
Route::apiResource('indicators-of-social-functioning', IndicatorOfSocialFunctioningController::class);
});
//Psychological Intervention Plan Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::post('/psychological-intervention-plans', [PsychologicalInterventionPlanController::class, 'store']);
Route::get('/psychological-intervention-plans/{id}', [PsychologicalInterventionPlanController::class, 'show']);
Route::put('/psychological-intervention-plans/{id}', [PsychologicalInterventionPlanController::class, 'update']);
});

//Initial Psychological Assessment Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/initial-psychological-assessments', [InitialPsychologicalAssessmentController::class, 'index']);
Route::get('/initial-psychological-assessments/{client_id}/{admission_id}', [InitialPsychologicalAssessmentController::class, 'show']);
Route::get('/initial-psychological-assessments/{client_id}', [InitialPsychologicalAssessmentController::class, 'show']);
Route::post('/initial-psychological-assessments', [InitialPsychologicalAssessmentController::class, 'store']);
Route::put('/initial-psychological-assessments/{id}', [InitialPsychologicalAssessmentController::class, 'update']);
Route::delete('/initial-psychological-assessments/{id}', [InitialPsychologicalAssessmentController::class, 'destroy']);
});
// Cicl Progress Notes Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/cicl-progress-notes', [CiclProgressNoteController::class, 'index']);
Route::get('/cicl-progress-notes/{client_id}', [CiclProgressNoteController::class, 'show']);
Route::post('/cicl-progress-notes', [CiclProgressNoteController::class, 'store']);
Route::put('/cicl-progress-notes/{client_id}', [CiclProgressNoteController::class, 'update']);
Route::delete('/cicl-progress-notes/{id}', [CiclProgressNoteController::class, 'destroy']);
});
// Anecdotal Report Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/anecdotal-reports', [AnecdotalReportController::class, 'index']);
Route::get('/anecdotal-reports/{client_id}', [AnecdotalReportController::class, 'show']);
Route::post('/anecdotal-reports', [AnecdotalReportController::class, 'store']);
Route::put('/anecdotal-reports/{client_id}', [AnecdotalReportController::class, 'update']);
Route::delete('/anecdotal-reports/{id}', [AnecdotalReportController::class, 'destroy']);
});
// Incident Report Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/incident-reports', [IncidentReportController::class, 'index']);
Route::get('/incident-reports/{client_id}', [IncidentReportController::class, 'show']);
Route::post('/incident-reports', [IncidentReportController::class, 'store']);
Route::put('/incident-reports/{client_id}', [IncidentReportController::class, 'update']);
Route::delete('/incident-reports/{id}', [IncidentReportController::class, 'destroy']);
});
//Monthly Inventory Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('monthly-inventories/{client_id}', [MonthlyInventoryController::class, 'show']);
Route::post('monthly-inventories', [MonthlyInventoryController::class, 'store']); // For creating
Route::put('monthly-inventories', [MonthlyInventoryController::class, 'store']); // For updating
Route::delete('monthly-inventories/{id}', [MonthlyInventoryController::class, 'destroy']);
});
//Cicl Session Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/cicl-sessions', [CiclSessionController::class, 'index']);
Route::get('/cicl-sessions/{client_id}', [CiclSessionController::class, 'show']);
Route::post('/cicl-sessions', [CiclSessionController::class, 'store']);
Route::put('/cicl-sessions/{client_id}', [CiclSessionController::class, 'update']);
Route::delete('/cicl-sessions/{id}', [CiclSessionController::class, 'destroy']);
Route::put('/cicl-sessions/{id}', [CiclSessionController::class, 'update']);
});
//Swapping Form Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/swapping-forms', [SwappingFormController::class, 'index']);
Route::get('/swapping-forms/{client_id}', [SwappingFormController::class, 'show']);
Route::post('/swapping-forms', [SwappingFormController::class, 'store']);
Route::put('/swapping-forms/{client_id}', [SwappingFormController::class, 'update']);
Route::delete('/swapping-forms/{id}', [SwappingFormController::class, 'destroy']);
});
// Nursing Care Service Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/nursing-care-services', [NursingCareServiceController::class, 'index']);
Route::get('/nursing-care-services/{id}', [NursingCareServiceController::class, 'show']);
Route::post('/nursing-care-services', [NursingCareServiceController::class, 'storeOrUpdate']);
Route::put('/nursing-care-services/{id}', [NursingCareServiceController::class, 'storeOrUpdate']);
Route::delete('/nursing-care-services/{id}', [NursingCareServiceController::class, 'destroy']);
Route::get('/nursing-care-services/client/{clientId}', [NursingCareServiceController::class, 'getByClientId']);
});
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/performance-observation-reports/{client_id}', [PerformanceObservationReportController::class, 'index']);
Route::get('/performance-observation-reports/{client_id}/show', [PerformanceObservationReportController::class, 'show']);
Route::delete('/performance-observation-reports/{client_id}', [PerformanceObservationReportController::class, 'destroy']);
Route::post('/performance-observation-reports', [PerformanceObservationReportController::class, 'storeOrUpdate']);
Route::put('/performance-observation-reports/{client_id}', [PerformanceObservationReportController::class, 'storeOrUpdate']);
});

//Training Needs Assessment Routes
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/training-needs-assessment/{client_id}', [TrainingNeedsAssessmentController::class, 'show']);
Route::put('/training-needs-assessment/{client_id}', [TrainingNeedsAssessmentController::class, 'storeOrUpdate']);
});
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/learner-academic-behavioral-forms/{client_id}', [LearnerAcademicBehavioralFormController::class, 'show']);
Route::post('/learner-academic-behavioral-forms', [LearnerAcademicBehavioralFormController::class, 'storeOrUpdate']);
Route::get('/learner-assessment-forms/{client_id}', [LearnerAssessmentFormController::class, 'show']);
Route::post('/learner-assessment-forms', [LearnerAssessmentFormController::class, 'storeOrUpdate']);
});

// File and Folder Operations with clientId
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/folders-and-files/{clientId}', [FileController::class, 'index']);
Route::post('/create-folder', [FileController::class, 'createFolder']);
Route::post('/upload', [FileController::class, 'uploadFile']);
Route::post('/move-file', [FileController::class, 'moveFile']);
Route::post('/delete-folder', [FileController::class, 'deleteFolder']);
Route::post('/delete-file', [FileController::class, 'deleteFile']);
});

use App\Http\Controllers\LogController;

Route::get('/logs', [LogController::class, 'index']);
Route::get('/logs/{id}', [LogController::class, 'show']);
Route::post('/logs', [LogController::class, 'store']);

//case manager
Route::post('/case-manager', [CaseManagerController::class, 'storeCaseManager']);
Route::get('/case-manager/{clientId}', [CaseManagerController::class, 'getCaseManager']);
Route::put('/update-case-manager/{clientId}', [CaseManagerController::class, 'storeCaseManager']);
Route::get('/case-manager/{clientId}', [CaseManagerController::class, 'getCaseManager']);


// API routes for SHP
Route::post('/shp', [SHPController::class, 'storeSHP']);
Route::get('/shp/{clientId}', [SHPController::class, 'getSHP']);
Route::put('/update-shp/{clientId}', [SHPController::class, 'storeSHP']);

// DRN API Routes
Route::post('/drn', [DrnController::class, 'storeDrn']); // This should handle both create and update
Route::get('/drn/{clientId}', [DrnController::class, 'getDrn']);

// routes/api.php
Route::get('/center-head', [CenterHeadController::class, 'getCenterHead']);


use App\Http\Controllers\CrimeController;

Route::get('/crimes', [CrimeController::class, 'getCrimes']);


use App\Http\Controllers\RtcController;

// Route to fetch all RTC provinces with branches
Route::get('/rtcBranches', [RtcController::class, 'getRtcBranches']);
