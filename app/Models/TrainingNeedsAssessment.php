<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class TrainingSectorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_needs_assessment_id', 'sector', 'name', 'rank', 'remarks',
        'updated_by'
    ];

    public function trainingNeedsAssessment()
    {
        return $this->belongsTo(TrainingNeedsAssessment::class);
    }
}

class TrainingNeedsAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'birthplace', 'social_worker', 'houseparent',
        'father', 'mother', 'address', 'center_duration',
        'for_the', 'date_of_admission'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function educationDetails()
    {
        return $this->hasMany(EducationDetail::class);
    }

    public function trainingDetails()
    {
        return $this->hasMany(TrainingDetail::class);
    }

    public function trainingSectorDetails()
    {
        return $this->hasMany(TrainingSectorDetail::class);
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
