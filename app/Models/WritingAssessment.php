<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class WritingAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_assessment_form_id',
        'punctuation',
        'punctuation_remarks',
        'capitalization',
        'capitalization_remarks',
        'grammar',
        'grammar_remarks',
        'content_ideas',
        'content_ideas_remarks',
        'spelling',
        'spelling_remarks',
        'updated_by'
    ];

    protected $casts = [
        'punctuation' => 'array',
        'capitalization' => 'array',
        'grammar' => 'array',
        'content_ideas' => 'array',
        'spelling' => 'array',
    ];

    public function learnerAssessmentForm()
    {
        return $this->belongsTo(LearnerAssessmentForm::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            // Log the entire session data for debugging
            Log::info('Session Data', Session::all());

            // Get the user's first name from the session
            $userFname = Session::get('user_fname');

            // Log the specific 'user_fname' from the session
            Log::info('Updating Checklist', ['user_fname' => $userFname]);

            // Set the 'updated_by' field to the user's first name from the session
            if ($userFname) {
                $model->updated_by = $userFname;
            } else {
                Log::warning('User first name not found in session');
            }
        });
    }
}
