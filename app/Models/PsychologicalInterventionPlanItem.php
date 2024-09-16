<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class PsychologicalInterventionPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'objectives',
        'activities',
        'responsible_person',
        'time_frame',
        'expected_output',
        'progress',
        'updated_by'
    ];

    public function plan()
    {
        return $this->belongsTo(PsychologicalInterventionPlan::class, 'plan_id');
    }
    // Automatically update the 'updated_by' field when the model is created or updated
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Log the entire session data for debugging
            Log::info('Session Data', Session::all());

            // Get the user's first name from the session
            $userFname = Session::get('user_fname');

            // Log the specific 'user_fname' from the session
            Log::info('Creating Admission', ['user_fname' => $userFname]);

            // Set the 'updated_by' field to the user's first name from the session
            if ($userFname) {
                $model->updated_by = $userFname;
            } else {
                Log::warning('User first name not found in session during creation');
            }
        });

        static::updating(function ($model) {
            // Log the entire session data for debugging
            Log::info('Session Data', Session::all());

            // Get the user's first name from the session
            $userFname = Session::get('user_fname');

            // Log the specific 'user_fname' from the session
            Log::info('Updating Admission', ['user_fname' => $userFname]);

            // Set the 'updated_by' field to the user's first name from the session
            if ($userFname) {
                $model->updated_by = $userFname;
            } else {
                Log::warning('User first name not found in session during update');
            }
        });
    }
}
