<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class GeneralIntakeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'occupation',
        'highest_educ_att',
        'school_name',
        'class_adviser',
        'problem_presented',
        'brief_physical_description',
        'major_life_event',
        'enduring_life_strain',
        'life_transition',
        'development_changes',
        'normalization',
        'behaviour_towards_incident',
        'attachments',
        'skills',
        'resources',
        'earnings_income',
        'source_of_income_in_street',
        'hrs_stay_in_street',
        'length_stay_in_street',
        'common_substance_used',
        'initial_assessment',
        'recommendations',
        'prepared_by',
        'reviewed_by',
        'updated_by'
    ];

    protected $casts = [
        'major_life_event' => 'array',
        'enduring_life_strain' => 'array',
        'life_transition' => 'array',
        'development_changes' => 'array',
        'normalization' => 'array',
        'behaviour_towards_incident' => 'array',
        'attachments' => 'array',
        'skills' => 'array',
        'resources' => 'array',
        'source_of_income_in_street' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function generalIntakeSheet()
    {
        return $this->belongsTo(GeneralIntakeSheet::class, 'general_intake_id');
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
