<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions
class GroupWorkAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_assessment_form_id',
        'participation',
        'participation_remarks',
        'focus',
        'focus_remarks',
        'help',
        'help_remarks',
        'questions',
        'questions_remarks',
        'ideas',
        'ideas_remarks',
        'feedback',
        'feedback_remarks',
        'updated_by'
    ];

    protected $casts = [
        'participation' => 'array',
        'focus' => 'array',
        'help' => 'array',
        'questions' => 'array',
        'ideas' => 'array',
        'feedback' => 'array',
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

    /**
     * Handle logging for created and updated events
     * 
     * @param  \App\Models\GroupWorkAssessment  $model
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

        Logger::info('GroupWorkAssessment ' . ucfirst($action), [
            'updated_by' => $fullName,
            'user_role' => $userRole,
        ]);

        // Log the action in the logs table
        Log::create([
            'model' => 'GroupWorkAssessment',
            'record_id' => $model->id,
            'action' => $action,
            'changes' => json_encode($model->getAttributes()), // Log the model's attributes
            'updated_by' => $fullName,
            'user_role' => $userRole,
        ]);
    }
}
