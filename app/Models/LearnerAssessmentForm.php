<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions

class LearnerAssessmentForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'school_year',
        'grading_period',
        'grade',
        'date',
        'recommendations',
        'prepared_by',
        'noted_by',
        'updated_by'
    ];

    public function readingAssessments()
    {
        return $this->hasOne(ReadingAssessment::class);
    }

    public function writingAssessments()
    {
        return $this->hasOne(WritingAssessment::class);
    }

    public function numeracyAssessments()
    {
        return $this->hasOne(NumeracyAssessment::class);
    }

    public function groupWorkAssessments()
    {
        return $this->hasOne(GroupWorkAssessment::class);
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
 
     /**
      * Handle logging for created and updated events
      * 
      * @param  \App\Models\LearnerAssessmentForm  $model
      * @param  string  $action
      * @return void
      */
     protected static function handleLogging($model, $action)
     {
         // Log the session data for debugging
         Logger::info('Session Data', Session::all());
 
         // Fetch the user's first name, last name, and role from the session
         $userFname = Session::get('user_fname');
         $userLname = Session::get('user_lname');
         $userRole = Session::get('user_role');
 
         if (!$userFname || !$userLname || !$userRole) {
             Logger::warning('User details not found in session during ' . $action);
             return;
         }
 
         // Concatenate the first name and last name to create the full name
         $fullName = trim($userFname . ' ' . $userLname);
 
         // Ensure the client relationship is loaded
         $model->load('client');
 
         // Fetch the client details and concatenate to form the full name
         $client = $model->client;
         $clientFullName = '';
         if ($client) {
             $clientFullName = trim(
                 $client->first_name . ' ' .
                 ($client->middle_name ? $client->middle_name . ' ' : '') .
                 $client->last_name .
                 ($client->suffix ? ', ' . $client->suffix : '')
             );
         }
 
         Logger::info('LearnerAssessmentForm ' . ucfirst($action), [
             'updated_by' => $fullName,
             'user_role' => $userRole,
             'client_full_name' => $clientFullName,
         ]);
 
         // Log the action in the logs table
         Log::create([
             'model' => 'LearnerAssessmentForm',
             'record_id' => $model->id,
             'action' => $action,
             'changes' => json_encode($model->getAttributes()), // Log the model's attributes
             'updated_by' => $fullName,
             'user_role' => $userRole,
             'client_full_name' => $clientFullName,
         ]);
     }
}
