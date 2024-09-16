<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class IndicatorsOfSocialFunctioning extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'admission_id',
        'date_administered',
        'physical_raw_score1',
        'physical_score_per_area1',
        'physical_raw_score2',
        'emotional_raw_score1',
        'emotional_score_per_area1',
        'emotional_raw_score2',
        'emotional_raw_score3',
        'emotional_raw_score4',
        'emotional_raw_score5',
        'emotional_raw_score6',
        'social_raw_score1',
        'social_score_per_area1',
        'social_raw_score2',
        'social_raw_score3',
        'social_raw_score4',
        'social_raw_score5',
        'social_raw_score6',
        'social_raw_score7',
        'social_raw_score8',
        'spiritual_raw_score1',
        'spiritual_score_per_area1',
        'educational_raw_score',
        'educational_score_per_area',
        'economic_raw_score',
        'economic_score_per_area',
        'general_score',
        'interpretation',
        'prepared_by',
        'discussed_with',
        'updated_by'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
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