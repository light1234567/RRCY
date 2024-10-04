<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions
class ReadingAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_assessment_form_id',
        'pronunciation_remarks',
        'pronunciation',
        'fluency',
        'punctuation',
        'updated_by'
    ];

    public function learnerAssessmentForm()
    {
        return $this->belongsTo(LearnerAssessmentForm::class);
    }
    
     // Boot method to handle logging and updating fields
     protected static function boot()
     {
         parent::boot();
 
         static::created(function ($model) {
             self::handleLogging($model, 'created');
         });
 
         static::updated(function ($model) {
             self::handleLogging($model, 'updated');
         });
     }
 
     protected static function handleLogging($model, $action)
     {
         Logger::info('Session Data', Session::all());
 
         $userFname = Session::get('user_fname');
         $userLname = Session::get('user_lname');
         $userRole = Session::get('user_role');
 
         if (!$userFname || !$userLname || !$userRole) {
             Logger::warning('User details not found in session during ' . $action);
             return;
         }
 
         $fullName = trim($userFname . ' ' . $userLname);
 
         Log::create([
             'model' => 'ReadingAssessment',
             'record_id' => $model->id,
             'action' => $action,
             'changes' => json_encode($model->getAttributes()),
             'updated_by' => $fullName,
             'user_role' => $userRole,
             'client_full_name' => null, // No direct client relationship in this model
         ]);
     }
}